<?php

declare(strict_types=1);


/**
 * Circles - Bring cloud-users closer together.
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2021
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\Circles\Service;


use ArtificialOwl\MySmallPhpTools\Traits\Nextcloud\nc22\TNC22Logger;
use ArtificialOwl\MySmallPhpTools\Traits\TArrayTools;
use ArtificialOwl\MySmallPhpTools\Traits\TStringTools;
use Exception;
use OC;
use OCA\Circles\AppInfo\Application;
use OCA\Circles\Db\CircleRequest;
use OCA\Circles\Db\MemberRequest;
use OCA\Circles\Exceptions\CircleNotFoundException;
use OCA\Circles\Exceptions\ContactAddressBookNotFoundException;
use OCA\Circles\Exceptions\ContactFormatException;
use OCA\Circles\Exceptions\ContactNotFoundException;
use OCA\Circles\Exceptions\FederatedEventException;
use OCA\Circles\Exceptions\FederatedItemException;
use OCA\Circles\Exceptions\FederatedUserException;
use OCA\Circles\Exceptions\FederatedUserNotFoundException;
use OCA\Circles\Exceptions\GroupNotFoundException;
use OCA\Circles\Exceptions\InitiatorNotConfirmedException;
use OCA\Circles\Exceptions\InitiatorNotFoundException;
use OCA\Circles\Exceptions\InvalidIdException;
use OCA\Circles\Exceptions\MemberNotFoundException;
use OCA\Circles\Exceptions\OwnerNotFoundException;
use OCA\Circles\Exceptions\RemoteInstanceException;
use OCA\Circles\Exceptions\RemoteNotFoundException;
use OCA\Circles\Exceptions\RemoteResourceNotFoundException;
use OCA\Circles\Exceptions\RequestBuilderException;
use OCA\Circles\Exceptions\SingleCircleNotFoundException;
use OCA\Circles\Exceptions\UnknownRemoteException;
use OCA\Circles\Exceptions\UserTypeNotFoundException;
use OCA\Circles\FederatedItems\CircleCreate;
use OCA\Circles\IFederatedUser;
use OCA\Circles\Model\Circle;
use OCA\Circles\Model\Federated\FederatedEvent;
use OCA\Circles\Model\Federated\RemoteInstance;
use OCA\Circles\Model\FederatedUser;
use OCA\Circles\Model\ManagedModel;
use OCA\Circles\Model\Member;
use OCP\IGroupManager;
use OCP\IUser;
use OCP\IUserManager;
use OCP\IUserSession;


/**
 * Class FederatedUserService
 *
 * @package OCA\Circles\Service
 */
class FederatedUserService {


	use TArrayTools;
	use TStringTools;
	use TNC22Logger;


	const CONFLICT_001 = 1;
	const CONFLICT_002 = 2;
	const CONFLICT_003 = 3;
	const CONFLICT_004 = 4;
	const CONFLICT_005 = 5;


	/** @var IUserSession */
	private $userSession;

	/** @var IUserManager */
	private $userManager;

	/** @var IGroupManager */
	private $groupManager;

	/** @var FederatedEventService */
	private $federatedEventService;

	/** @var MembershipService */
	private $membershipService;

	/** @var CircleRequest */
	private $circleRequest;

	/** @var MemberRequest */
	private $memberRequest;

	/** @var RemoteService */
	private $remoteService;

	/** @var RemoteStreamService */
	private $remoteStreamService;

	/** @var ContactService */
	private $contactService;

	/** @var InterfaceService */
	private $interfaceService;

	/** @var ConfigService */
	private $configService;


	/** @var FederatedUser */
	private $currentUser = null;

	/** @var FederatedUser */
	private $currentApp = null;

	/** @var RemoteInstance */
	private $remoteInstance = null;

	/** @var bool */
	private $bypass = false;

	/** @var bool */
	private $initiatedByOcc = false;

	/** @var FederatedUser */
	private $initiatedByAdmin = null;


	/**
	 * FederatedUserService constructor.
	 *
	 * @param IUserSession $userSession
	 * @param IUserManager $userManager
	 * @param IGroupManager $groupManager
	 * @param FederatedEventService $federatedEventService
	 * @param MembershipService $membershipService
	 * @param CircleRequest $circleRequest
	 * @param MemberRequest $memberRequest
	 * @param RemoteService $remoteService
	 * @param RemoteStreamService $remoteStreamService
	 * @param ContactService $contactService
	 * @param InterfaceService $interfaceService
	 * @param ConfigService $configService
	 */
	public function __construct(
		IUserSession $userSession,
		IUserManager $userManager,
		IGroupManager $groupManager,
		FederatedEventService $federatedEventService,
		MembershipService $membershipService,
		CircleRequest $circleRequest,
		MemberRequest $memberRequest,
		RemoteService $remoteService,
		RemoteStreamService $remoteStreamService,
		ContactService $contactService,
		InterfaceService $interfaceService,
		ConfigService $configService
	) {
		$this->userSession = $userSession;
		$this->userManager = $userManager;
		$this->groupManager = $groupManager;
		$this->federatedEventService = $federatedEventService;
		$this->membershipService = $membershipService;
		$this->circleRequest = $circleRequest;
		$this->memberRequest = $memberRequest;
		$this->remoteService = $remoteService;
		$this->remoteStreamService = $remoteStreamService;
		$this->contactService = $contactService;
		$this->interfaceService = $interfaceService;
		$this->configService = $configService;

		if (OC::$CLI) {
			$this->setInitiatedByOcc(true);
		}
	}


	/**
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws SingleCircleNotFoundException
	 * @throws RequestBuilderException
	 */
	public function initCurrentUser() {
		$user = $this->userSession->getUser();
		if ($user === null) {
			return;
		}

		$this->setLocalCurrentUser($user);
	}


	/**
	 * @param IUser|null $user
	 *
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws SingleCircleNotFoundException
	 * @throws RequestBuilderException
	 */
	public function setLocalCurrentUser(?IUser $user): void {
		if ($user === null) {
			return;
		}

		$this->setLocalCurrentUserId($user->getUID());
	}

	/**
	 * @param string $userId
	 *
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function setLocalCurrentUserId(string $userId): void {
		$this->currentUser = $this->getLocalFederatedUser($userId);
	}

	/**
	 * @param string $appId
	 * @param int $appNumber
	 *
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws SingleCircleNotFoundException
	 */
	public function setLocalCurrentApp(string $appId, int $appNumber): void {
		$this->currentApp = $this->getAppInitiator($appId, $appNumber);
	}


	/**
	 * set a CurrentUser, based on a IFederatedUser.
	 * CurrentUser is mainly used to manage rights when requesting the database.
	 *
	 * @param IFederatedUser $federatedUser
	 *
	 * @throws FederatedUserException
	 */
	public function setCurrentUser(IFederatedUser $federatedUser): void {
		if (!($federatedUser instanceof FederatedUser)) {
			$tmp = new FederatedUser();
			$tmp->importFromIFederatedUser($federatedUser);
			$federatedUser = $tmp;
		}

		$this->confirmFederatedUser($federatedUser);

		$this->currentUser = $federatedUser;
	}

	/**
	 *
	 */
	public function unsetCurrentUser(): void {
		$this->currentUser = null;
	}

	/**
	 * @return FederatedUser|null
	 */
	public function getCurrentUser(): ?FederatedUser {
		return $this->currentUser;
	}

	/**
	 * @return bool
	 */
	public function hasCurrentUser(): bool {
		return !is_null($this->currentUser);
	}

	/**
	 * @throws InitiatorNotFoundException
	 */
	public function mustHaveCurrentUser(): void {
		if ($this->bypass) {
			return;
		}
		if (!$this->hasCurrentUser() && !$this->hasRemoteInstance()) {
			throw new InitiatorNotFoundException('Invalid initiator');
		}
	}

	/**
	 * @param bool $bypass
	 */
	public function bypassCurrentUserCondition(bool $bypass): void {
		$this->bypass = $bypass;
	}


	/**
	 * @param bool $initiatedByOcc
	 */
	public function setInitiatedByOcc(bool $initiatedByOcc): void {
		$this->initiatedByOcc = $initiatedByOcc;
	}

	/**
	 * @return bool
	 */
	public function isInitiatedByOcc(): bool {
		return $this->initiatedByOcc;
	}

	/**
	 * @return bool
	 */
	public function isInitiatedByAdmin(): bool {
		return !is_null($this->initiatedByAdmin);
	}

	/**
	 * @param FederatedUser $patron
	 */
	public function setInitiatedByAdmin(FederatedUser $patron): void {
		$this->initiatedByAdmin = $patron;
	}

	/**
	 * @return FederatedUser
	 */
	public function getInitiatedByAdmin(): FederatedUser {
		return $this->initiatedByAdmin;
	}

	/**
	 * @param IUser $user
	 *
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function setCurrentPatron(string $userId): void {
		$patron = $this->getLocalFederatedUser($userId, false);

		$this->setInitiatedByAdmin($patron);
	}


	/**
	 * @param Member $member
	 *
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function setMemberPatron(Member $member): void {
		if ($this->isInitiatedByOcc()) {
			$member->setInvitedBy($this->getAppInitiator('occ', Member::APP_OCC));
		} else if ($this->isInitiatedByAdmin()) {
			$member->setInvitedBy($this->getInitiatedByAdmin());
		} else {
			$member->setInvitedBy($this->getCurrentUser());
		}
	}


	/**
	 * @return FederatedUser|null
	 */
	public function getCurrentApp(): ?FederatedUser {
		return $this->currentApp;
	}

	/**
	 * @return bool
	 */
	public function hasCurrentApp(): bool {
		return !is_null($this->currentApp);
	}


	/**
	 * set a RemoteInstance, mostly from a remote request (RemoteController)
	 * Used to limit rights in some request in the local database.
	 *
	 * @param RemoteInstance $remoteInstance
	 */
	public function setRemoteInstance(RemoteInstance $remoteInstance): void {
		$this->remoteInstance = $remoteInstance;
	}

	/**
	 * @return RemoteInstance|null
	 */
	public function getRemoteInstance(): ?RemoteInstance {
		return $this->remoteInstance;
	}

	/**
	 * @return bool
	 */
	public function hasRemoteInstance(): bool {
		return !is_null($this->remoteInstance);
	}


	/**
	 * Get the full FederatedUser for a local user.
	 * Will generate the SingleId if none exist
	 *
	 * @param string $userId
	 * @param bool $check
	 *
	 * @return FederatedUser
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function getLocalFederatedUser(string $userId, bool $check = true): FederatedUser {
		$displayName = $userId;
		if ($check) {
			$user = $this->userManager->get($userId);
			if ($user === null) {
				throw new FederatedUserNotFoundException('user ' . $userId . ' not found');
			}
			$userId = $user->getUID();
			$displayName = $user->getDisplayName();
		}

		$federatedUser = new FederatedUser();
		$federatedUser->set($userId, '', Member::TYPE_USER, $displayName);
		$this->fillSingleCircleId($federatedUser, $check);

		return $federatedUser;
	}


	/**
	 * Get the full FederatedUser for a local user.
	 * Will generate the SingleId if none exist
	 *
	 * @param string $appId
	 * @param int $appNumber
	 *
	 * @return FederatedUser
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function getAppInitiator(
		string $appId,
		int $appNumber,
		string $appDisplayName = ''
	): FederatedUser {
		if ($appDisplayName === '') {
			$appDisplayName = $this->get((string)$appNumber, Circle::$DEF_SOURCE, $appId);
		}

		$circle = new Circle();
		$circle->setSource($appNumber);

		$federatedUser = new FederatedUser();
		$federatedUser->set($appId, '', Member::TYPE_APP, $appDisplayName, $circle);

		$this->fillSingleCircleId($federatedUser);

		return $federatedUser;
	}


	/**
	 * some ./occ commands allows to add an Initiator, or force the PoV from the local circles' owner
	 *
	 * TODO: manage non-user type ?
	 *
	 * @param string $userId
	 * @param int $userType
	 * @param string $circleId
	 * @param bool $bypass
	 *
	 * @throws CircleNotFoundException
	 * @throws FederatedItemException
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws MemberNotFoundException
	 * @throws OwnerNotFoundException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 * @throws UnknownRemoteException
	 * @throws UserTypeNotFoundException
	 */
	public function commandLineInitiator(
		string $userId,
		int $userType = Member::TYPE_SINGLE,
		string $circleId = '',
		bool $bypass = false
	): void {
		if ($userId !== '') {
			$this->setCurrentUser($this->getFederatedUser($userId, $userType));

			return;
		}

		if ($circleId !== '') {
			$localCircle = $this->circleRequest->getCircle($circleId, null, null, 0);
			if ($this->configService->isLocalInstance($localCircle->getInstance())) {
				$this->setCurrentUser($localCircle->getOwner());

				return;
			}
		}

		if (!$bypass) {
			throw new CircleNotFoundException(
				'This Circle is not managed from this instance, please use --initiator'
			);
		}

		$this->bypassCurrentUserCondition($bypass);
	}


	/**
	 * Works like getFederatedUser, but returns a member.
	 * Allow to specify a level: handle@instance,level
	 *
	 * Used for filters when searching for Circles
	 * TODO: Used outside of ./occ circles:manage:list ?
	 *
	 * @param string $userId
	 * @param int $level
	 *
	 * @return Member
	 * @throws CircleNotFoundException
	 * @throws FederatedItemException
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws MemberNotFoundException
	 * @throws OwnerNotFoundException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws SingleCircleNotFoundException
	 * @throws UnknownRemoteException
	 * @throws UserTypeNotFoundException
	 */
	public function getFederatedMember(string $userId, int $level = Member::LEVEL_MEMBER): Member {
		$userId = trim($userId, ',');
		if (strpos($userId, ',') !== false) {
			list($userId, $level) = explode(',', $userId);
		}

		$federatedUser = $this->getFederatedUser($userId, Member::TYPE_USER);
		$member = new Member();
		$member->importFromIFederatedUser($federatedUser);
		$member->setLevel((int)$level);

		return $member;
	}


	/**
	 * get a valid FederatedUser, based on the federatedId (userId@instance) and its type.
	 * If instance is local, get the local valid FederatedUser
	 * If instance is not local, get the remote valid FederatedUser
	 *
	 * @param string $federatedId
	 * @param int $type
	 *
	 * @return FederatedUser
	 * @throws CircleNotFoundException
	 * @throws FederatedItemException
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws MemberNotFoundException
	 * @throws OwnerNotFoundException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws SingleCircleNotFoundException
	 * @throws UnknownRemoteException
	 * @throws UserTypeNotFoundException
	 * @throws RequestBuilderException
	 */
	public function getFederatedUser(string $federatedId, int $type = Member::TYPE_SINGLE): FederatedUser {
		// if type=user, we check that handle@domain is not an actual local user
		if ($type === Member::TYPE_USER) {
			try {
				return $this->getLocalFederatedUser($federatedId);
			} catch (Exception $e) {
			}
		}

		list($singleId, $instance) = $this->extractIdAndInstance($federatedId);

		switch ($type) {
			case Member::TYPE_SINGLE:
			case Member::TYPE_CIRCLE:
				return $this->getFederatedUser_SingleId($singleId, $instance);
			case Member::TYPE_USER:
				return $this->getFederatedUser_User($singleId, $instance);
			case Member::TYPE_GROUP:
				return $this->getFederatedUser_Group($singleId, $instance);
			case Member::TYPE_MAIL:
				return $this->getFederatedUser_Mail($federatedId);
			case Member::TYPE_CONTACT:
				return $this->getFederatedUser_Contact($federatedId);
		}

		throw new UserTypeNotFoundException();
	}


	/**
	 * Generate a FederatedUser based on local data.
	 * WARNING: There is no confirmation that the returned FederatedUser exists or is valid at this point.
	 * Use getFederatedUser() instead if a valid and confirmed FederatedUser is needed.
	 *
	 * if $federatedId is a known SingleId, will returns data from the local database.
	 * if $federatedId is a local username, will returns data from the local database.
	 * Otherwise, the FederatedUser will not contains a SingleId.
	 *
	 * @param string $federatedId
	 * @param int $type
	 *
	 * @return FederatedUser
	 */
	public function generateFederatedUser(string $federatedId, int $type = 0): FederatedUser {
		try {
			return $this->getFederatedUser($federatedId, $type);
		} catch (Exception $e) {
		}

		list($userId, $instance) = $this->extractIdAndInstance($federatedId);
		$federatedUser = new FederatedUser();
		$federatedUser->set($userId, $instance, $type);

		return $federatedUser;
	}


	/**
	 * @param FederatedUser $federatedUser
	 */
	public function deleteFederatedUser(FederatedUser $federatedUser): void {
		$this->circleRequest->deleteFederatedUser($federatedUser);
		$this->memberRequest->deleteFederatedUser($federatedUser);
		$this->membershipService->deleteFederatedUser($federatedUser);
	}


	/**
	 * @param string $singleId
	 * @param string $instance
	 *
	 * @return FederatedUser
	 * @throws CircleNotFoundException
	 * @throws FederatedItemException
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws MemberNotFoundException
	 * @throws OwnerNotFoundException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws UnknownRemoteException
	 * @throws RequestBuilderException
	 */
	public function getFederatedUser_SingleId(string $singleId, string $instance): FederatedUser {
		if ($this->configService->isLocalInstance($instance)) {
			return $this->circleRequest->getFederatedUserBySingleId($singleId);
		} else {
			$federatedUser = $this->remoteService->getFederatedUserFromInstance(
				$singleId,
				$instance,
				Member::TYPE_SINGLE
			);

			$this->confirmSingleIdUniqueness($federatedUser);

			return $federatedUser;
		}
	}


	/**
	 * @param string $userId
	 * @param string $instance
	 *
	 * @return FederatedUser
	 * @throws FederatedUserException
	 * @throws FederatedUserNotFoundException
	 * @throws InvalidIdException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws SingleCircleNotFoundException
	 * @throws UnknownRemoteException
	 * @throws FederatedItemException
	 * @throws RequestBuilderException
	 */
	private function getFederatedUser_User(string $userId, string $instance): FederatedUser {
		if ($this->configService->isLocalInstance($instance)) {
			return $this->getLocalFederatedUser($userId);
		} else {
			$federatedUser = $this->remoteService->getFederatedUserFromInstance(
				$userId,
				$instance,
				Member::TYPE_USER
			);

			$this->confirmSingleIdUniqueness($federatedUser);

			return $federatedUser;
		}
	}


	/**
	 * @param string $groupName
	 * @param string $instance
	 *
	 * @return FederatedUser
	 * @throws FederatedEventException
	 * @throws FederatedItemException
	 * @throws FederatedUserException
	 * @throws GroupNotFoundException
	 * @throws InitiatorNotConfirmedException
	 * @throws InvalidIdException
	 * @throws OwnerNotFoundException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws SingleCircleNotFoundException
	 * @throws UnknownRemoteException
	 * @throws RequestBuilderException
	 */
	public function getFederatedUser_Group(string $groupName, string $instance): FederatedUser {
		if ($this->configService->isLocalInstance($instance)) {
			$circle = $this->getGroupCircle($groupName);
			$federatedGroup = new FederatedUser();

			return $federatedGroup->importFromCircle($circle);
		} else {
			// TODO: implement remote groups
		}
	}


	/**
	 * @param string $mailAddress
	 *
	 * @return FederatedUser
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function getFederatedUser_Mail(string $mailAddress): FederatedUser {
		$federatedUser = new FederatedUser();
		$federatedUser->set($mailAddress, '', Member::TYPE_MAIL);
		$this->fillSingleCircleId($federatedUser);

		return $federatedUser;
	}


	/**
	 * @param string $contactPath
	 *
	 * @return FederatedUser
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	public function getFederatedUser_Contact(string $contactPath): FederatedUser {
		$federatedUser = new FederatedUser();
		$federatedUser->set(
			$contactPath,
			'',
			Member::TYPE_CONTACT,
			$this->contactService->getDisplayName($contactPath)
		);

		$this->fillSingleCircleId($federatedUser);

		return $federatedUser;
	}


	/**
	 * extract userID and instance from a federatedId
	 *
	 * @param string $federatedId
	 *
	 * @return array
	 */
	public function extractIdAndInstance(string $federatedId): array {
		$federatedId = trim($federatedId, '@');
		if (strrpos($federatedId, '@') === false) {
			$userId = $federatedId;
			$instance = $this->interfaceService->getLocalInstance();
		} else {
			list($userId, $instance) = explode('@', $federatedId);
		}

		return [$userId, $instance];
	}


	/**
	 * @param FederatedUser $federatedUser
	 * @param bool $generate
	 *
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	private function fillSingleCircleId(FederatedUser $federatedUser, bool $generate = true): void {
		if ($federatedUser->getSingleId() !== '') {
			return;
		}

		$circle = $this->getSingleCircle($federatedUser, $generate);
		$federatedUser->setSingleId($circle->getSingleId());
		$federatedUser->setDisplayName($circle->getDisplayName());
		$federatedUser->setBasedOn($circle);
	}


	/**
	 * get the Single Circle from a local user
	 *
	 * @param FederatedUser $federatedUser
	 * @param bool $generate
	 *
	 * @return Circle
	 * @throws ContactAddressBookNotFoundException
	 * @throws ContactFormatException
	 * @throws ContactNotFoundException
	 * @throws FederatedUserException
	 * @throws InvalidIdException
	 * @throws RequestBuilderException
	 * @throws SingleCircleNotFoundException
	 */
	private function getSingleCircle(FederatedUser $federatedUser, bool $generate = true): Circle {
		if (!$this->configService->isLocalInstance($federatedUser->getInstance())) {
			throw new FederatedUserException('FederatedUser must be local');
		}

		try {
			return $this->circleRequest->getSingleCircle($federatedUser);
		} catch (SingleCircleNotFoundException $e) {
			if (!$generate) {
				throw new SingleCircleNotFoundException();
			}

			$circle = new Circle();
			$id = $this->token(ManagedModel::ID_LENGTH);

			if ($federatedUser->hasBasedOn()) {
				$source = $federatedUser->getBasedOn()->getSource();
			} else {
				$source = $federatedUser->getUserType();
			}

			$prefix = ($federatedUser->getUserType() === Member::TYPE_APP) ? 'app'
				: Member::$TYPE[$federatedUser->getUserType()];

			$circle->setName($prefix . ':' . $federatedUser->getUserId() . ':' . $id)
				   ->setDisplayName($federatedUser->getDisplayName())
				   ->setSingleId($id)
				   ->setSource($source);

			if ($federatedUser->getUserType() === Member::TYPE_APP) {
				$circle->setConfig(Circle::CFG_SINGLE | Circle::CFG_ROOT);
			} else {
				$circle->setConfig(Circle::CFG_SINGLE);
			}
			$this->circleRequest->save($circle);

			$owner = new Member();
			$owner->importFromIFederatedUser($federatedUser);
			$owner->setLevel(Member::LEVEL_OWNER)
				  ->setCircleId($id)
				  ->setSingleId($id)
				  ->setId($id)
				  ->setDisplayName($owner->getDisplayName())
				  ->setStatus('Member');

			if ($federatedUser->getUserType() !== Member::TYPE_APP) {
				$owner->setInvitedBy(
					$this->getAppInitiator(
						Application::APP_ID,
						Member::APP_CIRCLES,
						Application::APP_NAME
					)
				);
			}

			$this->memberRequest->save($owner);
			// TODO: should not be needed
			// $this->membershipService->onUpdate($id);
		}

		return $this->circleRequest->getSingleCircle($federatedUser);
	}


	/**
	 * Confirm that all field of a FederatedUser are filled.
	 *
	 * @param FederatedUser $federatedUser
	 *
	 * @throws FederatedUserException
	 */
	private function confirmFederatedUser(FederatedUser $federatedUser): void {
		if ($federatedUser->getUserId() === ''
			|| $federatedUser->getSingleId() === ''
			|| $federatedUser->getUserType() === 0
			|| $federatedUser->getInstance() === '') {
			$this->debug('FederatedUser is not empty', ['federatedUser' => $federatedUser]);
			throw new FederatedUserException('FederatedUser is not complete');
		}
	}

	/**
	 * Confirm that the singleId of a FederatedUser is unique and not used to any other member of the
	 * database.
	 *
	 * @param FederatedUser $federatedUser
	 *
	 * @throws FederatedUserException
	 * @throws RequestBuilderException
	 * @deprecated: use confirmSingleIdUniqueness()
	 */
	public function confirmLocalSingleId(IFederatedUser $federatedUser): void {
		$members = $this->memberRequest->getMembersBySingleId($federatedUser->getSingleId());

		foreach ($members as $member) {
			if (!$federatedUser->compareWith($member)) {
				$this->debug(
					'uniqueness of SingleId could not be confirmed',
					['federatedUser' => $federatedUser, 'localMember' => $member]
				);
				throw new FederatedUserException('uniqueness of SingleId could not be confirmed');
			}
		}
	}


	/**
	 * // TODO: implement this check in a maintenance background job
	 *
	 * @param IFederatedUser $federatedUser
	 *
	 * @throws FederatedUserException
	 * @throws RemoteNotFoundException
	 * @throws RequestBuilderException
	 * @throws UnknownRemoteException
	 */
	public function confirmSingleIdUniqueness(IFederatedUser $federatedUser): void {
		// TODO: check also with Circles singleId

		$remote = null;
		if (!$this->configService->isLocalInstance($federatedUser->getInstance())) {
			$remote = $this->remoteStreamService->getCachedRemoteInstance($federatedUser->getInstance());
		}

		$knownMembers = $this->memberRequest->getAlternateSingleId($federatedUser);
		foreach ($knownMembers as $knownMember) {
			if ($this->configService->isLocalInstance($federatedUser->getInstance())) {
				if ($this->configService->isLocalInstance($knownMember->getInstance())) {
					return;
				} else {
					$this->markConflict($federatedUser, $knownMember, self::CONFLICT_001);
				}
			}

			if (!$knownMember->hasRemoteInstance()) {
				$this->markConflict($federatedUser, $knownMember, self::CONFLICT_002);
			}

			$knownRemote = $knownMember->getRemoteInstance();
			if ($this->interfaceService->isInterfaceInternal($knownRemote->getInterface())
				&& !in_array($federatedUser->getInstance(), $knownRemote->getAliases())) {
				$this->markConflict($federatedUser, $knownMember, self::CONFLICT_003);
			}

			if (is_null($remote)) {
				$this->markConflict($federatedUser, $knownMember, self::CONFLICT_004);
			}

			if ($this->interfaceService->isInterfaceInternal($remote->getInterface())
				&& !in_array($knownMember->getInstance(), $remote->getAliases())) {
				$this->markConflict($federatedUser, $knownMember, self::CONFLICT_005);
			}
		}
	}


	/**
	 * @param IFederatedUser $federatedUser
	 * @param Member $knownMember
	 * @param int $conflict
	 *
	 * @throws FederatedUserException
	 */
	private function markConflict(IFederatedUser $federatedUser, Member $knownMember, int $conflict): void {
		switch ($conflict) {
			case self::CONFLICT_001:
				$message = 'duplicate singleId from another instance';
				break;
			case self::CONFLICT_002:
				$message = 'duplicate singleId has no known source';
				break;
			case self::CONFLICT_003:
				$message = 'federatedUser is not an alias from duplicate singleId';
				break;
			case self::CONFLICT_004:
				$message = 'federatedUser has no known source';
				break;
			case self::CONFLICT_005:
				$message = 'duplicate singleId is not an alias of federatedUser';
				break;

			default:
				$message = 'uniqueness of SingleId could not be confirmed';
		}

		// TODO: log conflict into database
		$this->log(
			3, $message, false,
			[
				'federatedUser' => $federatedUser,
				'knownMember'   => $knownMember
			]
		);

		throw new FederatedUserException($message);
	}

	/**
	 * @param string $groupId
	 *
	 * @return Circle
	 * @throws GroupNotFoundException
	 * @throws FederatedEventException
	 * @throws FederatedItemException
	 * @throws FederatedUserException
	 * @throws InitiatorNotConfirmedException
	 * @throws InvalidIdException
	 * @throws OwnerNotFoundException
	 * @throws RemoteInstanceException
	 * @throws RemoteNotFoundException
	 * @throws RemoteResourceNotFoundException
	 * @throws SingleCircleNotFoundException
	 * @throws UnknownRemoteException
	 * @throws RequestBuilderException
	 */
	public function getGroupCircle(string $groupId): Circle {
		$group = $this->groupManager->get($groupId);
		if ($group === null) {
			throw new GroupNotFoundException('group not found');
		}

		$this->setLocalCurrentApp(Application::APP_ID, Member::APP_CIRCLES);
		$owner = $this->getCurrentApp();

		$circle = new Circle();
		$circle->setName('group:' . $groupId)
			   ->setConfig(Circle::CFG_SYSTEM | Circle::CFG_NO_OWNER | Circle::CFG_HIDDEN)
			   ->setSingleId($this->token(ManagedModel::ID_LENGTH))
			   ->setSource(Member::TYPE_GROUP);

		$member = new Member();
		$member->importFromIFederatedUser($owner);
		$member->setId($this->token(ManagedModel::ID_LENGTH))
			   ->setCircleId($circle->getSingleId())
			   ->setLevel(Member::LEVEL_OWNER)
			   ->setStatus(Member::STATUS_MEMBER);
		$circle->setOwner($member)
			   ->setInitiator($member);

		try {
			return $this->circleRequest->searchCircle($circle, $owner);
		} catch (CircleNotFoundException $e) {
		}

		$circle->setDisplayName($groupId);

		$event = new FederatedEvent(CircleCreate::class);
		$event->setCircle($circle);
		$this->federatedEventService->newEvent($event);

		return $circle;
	}

}

