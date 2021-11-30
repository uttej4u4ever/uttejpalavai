<?php
return array (
  'uuid' => '486c5f92-c6c8-5c08-e4e8-b0365f50a3c4',
  'type' => 'contact',
  'recipients' => 'iam@uttejpalavai.com',
  'subject' => 'Contact Form',
  'reply' => 'Your message was sent, We will revert back soon. Thank you.',
  'buttonText' => 'Send e-mail',
  'captchaEnabled' => true,
  'visibilityMode' => 'all',
  'styles' => 
  array (
    'margin' => '0 0 0 0',
    'padding' => '5px 10px 5px 10px',
    'background' => '',
    'backgroundColor' => 'transparent',
    'backgroundPosition' => 'top left',
    'backgroundStretch' => 'tile',
    'backgroundOpacity' => '100',
    'borderRadius' => '0 0 0 0',
    'boxShadow' => 'none',
    'textColor' => 'inherit',
    'textStroke' => false,
    'linkColor' => 'inherit',
    'linkStroke' => false,
    'h1Color' => 'inherit',
    'h1Stroke' => false,
    'h2Color' => 'inherit',
    'h2Stroke' => false,
  ),
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'name',
      'type' => 'textfield',
      'title' => 'Name',
      'required' => true,
    ),
    1 => 
    array (
      'name' => 'mail',
      'type' => 'email',
      'title' => 'E-mail',
      'required' => true,
    ),
    2 => 
    array (
      'name' => 'message',
      'type' => 'textarea',
      'title' => 'Message',
      'required' => true,
    ),
  ),
  'badCaptcha' => 'Captcha could not be validated. Please try again.',
  'wrongRequest' => 'Wrong request',
  'isPassCaptcha' => false,
  'recaptchaPrivateKey' => '6LfEYU4UAAAAAOdwb4njfKHHzpeefW5a1FLNQmxE',
);
?>