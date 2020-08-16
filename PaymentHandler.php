<?php
define('FORMS', [
'addressinfo' => 'PaymentForms/addressinfo.php',
'total'       => 'PaymentForms/total.php',
'success'     => 'PaymentForms/success.php'
]);
define('VALIDATIONFOR', [
'addressinfo' =>
[
	'cardnumber' 	=> ['/^\d{4}-\d{4}-\d{4}-\d{4}$/', 'Example: "1234-5678-9123-4567"'],
	'cardowner'		=> 'required|Eng|spaces|min:4|max:30',
	'valdate'		=> ['/^\d{1,2}\/\d{2}$/', 'Example: "12/22"'],
	'cvv'			=> 'required|number|max:3|min:3'
],
'total' =>
[
	'fname'			=> 'required|Eng|min:3|max:20',
	'lname'			=> 'required|Eng|min:3|max:30',
	'email'			=> ['/^\w{2,}@\w{2,20}.\w{2,10}$/', 'Please Enter Valid Email'],
	'country'		=> 'required|Eng|spaces|min:2|max:40',
	'phone'			=> ['/^([0-9\s\(\)\+]){2,20}$/', 'Only Allowed 0-9, ,(,),+'],
	'city'			=> 'required|Eng|spaces|min:2|max:40',
	'postalcode'	=> 'required|number|min:2|max:6',
	'address'		=> 'required|word|min:5|max:255',
	'cardnumber'   => ['/^\d{4}-\d{4}-\d{4}-\d{4}$/', 'Example: "1234-5678-9123-4567"'],
  'cardowner'   => 'required|Eng|spaces|min:4|max:30',
  'valdate'   => ['/^\d{1,2}\/\d{2}$/', 'Example: "12/22"'],
  'cvv'     => 'required|numbers|max:3'
],
'success' => 
[
	'fname'      => 'required|Eng|min:3|max:20',
  'lname'     => 'required|Eng|min:3|max:30',
  'email'     => ['/^\w{2,}@\w{2,20}.\w{2,10}$/', 'Please Enter Valid Email'],
  'country'   => 'required|Eng|spaces|min:2|max:40',
  'phone'     => ['/^([0-9\s\(\)\+]){2,20}$/', 'Only Allowed 0-9, ,(,),+'],
  'city'      => 'required|Eng|spaces|min:2|max:40',
  'postalcode'  => 'required|number|min:2|max:6',
  'address'   => 'required|word|min:5|max:255',
  'cardnumber'   => ['/^\d{4}-\d{4}-\d{4}-\d{4}$/', 'Example: "1234-5678-9123-4567"'],
  'cardowner'   => 'required|Eng|spaces|min:4|max:30',
  'valdate'   => ['/^\d{1,2}\/\d{2}$/', 'Example: "12/22"'],
  'cvv'     => 'required|numbers|max:3'
]
]);
define('CODE', [
	'success' 	=> 'SCS',
	'error'		=> 'ERR' 
]);


function validate($string, $valdata, $readyExp = false, $errMessage = ''){
  if ($readyExp)
    return preg_match($valdata, $string) ? [] : [$errMessage];
  $dataToRegExp = [
      'number'  => ['regexp' => '[0-9]', 'error' => 'Can only contain numbers'],
      'eng'     => ['regexp' => '[a-z]', 'error' => 'Can only contain lower case'],
      'ENG'     => ['regexp' => '[A-Z]', 'error' => 'Can only contain upper case'],
      'Eng'     => ['regexp' => '[a-zA-z]', 'error' => 'Can only contain english letters'],
      'word'    => ['regexp' => '[\w]', 'error' => 'Can only contain english word characters'],
      'digits'  => ['regexp' => '[\d]', 'error' => 'Can only contain numbers']
  ];
  $data = explode('|', $valdata);
	$errors;

  $requiredIndex = array_search('required', $data);
  if (!isset($string) || is_null($string) || $string === '')
    if ($requiredIndex !== false)
      return ['Please fill the field'];
  if ($requiredIndex !== false)
    unset($data[$requiredIndex]);
    

  $spacesIndex = array_search('spaces', $data);
  if ($spacesIndex !== false){
    unset($data[$spacesIndex]);
    $string = str_replace(' ', '', $string);
  }

  $min = preg_filter('/^min:\d{1,4}$/', '$0', $data);
  if (!empty($min)){
    $i = array_values($min);
    unset($data[array_keys($min)[0]]);
    $min = substr($i[0], 4);
    if(strlen($string) < $min)
      $errors[] = 'it\'s to short, minimum '.$min.' characters';
  }
  $max = preg_filter('/^max:\d{1,4}$/', '$0', $data);
  if (!empty($max)){
    $i = array_values($max);
    unset($data[array_keys($max)[0]]);
    $max = substr($i[0], 4);
    if(strlen($string) > $max)
      $errors[] = 'it\'s to long, maximum '.$max.' characters';
  }

  foreach ($data as $value) {
    if(array_key_exists($value, $dataToRegExp)){
      $regexp = $dataToRegExp[$value]['regexp'];
      $matching = preg_match("/^$regexp{0,255}$/", $string);
      if (!$matching)
        $errors[] = $dataToRegExp[$value]['error'];
    }
  }
	
	return $errors;
}

if (isset($_POST['next'])){
  $nextFormName = $_POST['next'];
  if (!empty(VALIDATIONFOR[$nextFormName])){
    $errors = [];
    foreach (VALIDATIONFOR[$nextFormName] as $key => $value) {
      if (is_array($value) && count($value) === 1)
        $errors[$key] = validate($_POST[$key], $value[0]);
      elseif (is_string($value)) {
        $errors[$key] = validate($_POST[$key], $value);
      }
      elseif(is_array($value) && count($value) === 2) {
        $errors[$key] = validate($_POST[$key], $value[0], true, $value[1]);
      }

      if (empty($errors[$key]))
        unset($errors[$key]);
    }
    if (empty($errors)){
    	echo CODE['success'];
      include(FORMS[$nextFormName]);
    }
    else {
    	echo CODE['error'].json_encode($errors);
    }
  }
}