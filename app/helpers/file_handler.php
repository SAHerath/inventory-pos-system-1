<?php

function validateFiles($fileId, $fileCount, $validTypes, $maxSize = 1)
{
  $fileData = [
    'error' => '',
    $fileId => [],
    'path' => []
  ];

  if (isset($_FILES[$fileId])) {

    if ($fileCount > count($_FILES[$fileId]['tmp_name'])) {
      $fileCount = count($_FILES[$fileId]['tmp_name']);
    }

    for ($file = 0; $file < $fileCount; $file++) {

      if ($_FILES[$fileId]['error'][$file] > 0) {
        switch ($_FILES[$fileId]['error'][$file]) {
          case 1:
            $fileData['error'] = 'File too large, blocked by server';
            break;
          case 2:
            $fileData['error'] = 'File too large, blocked by browser';
            break;
          case 3:
            $fileData['error'] = 'File not fully uploaded';
            break;
          case 4:
            $fileData['error'] = 'File not uploaded';
            break;
          case 6:
            $fileData['error'] = 'Missing a temporary folder';
            break;
          case 7:
            $fileData['error'] = 'Failed to write file to disk';
            break;
          case 8:
            $fileData['error'] = 'File upload stopped by extension';
            break;
          default:
            $fileData['error'] = 'Unknown upload error';
            break;
        }
        break;
      } else {
        $type = explode('/', mime_content_type($_FILES[$fileId]['tmp_name'][$file]));
        if (!is_uploaded_file($_FILES[$fileId]['tmp_name'][$file])) {
          $fileData['error'] = 'File not accepted';
          break;
        } elseif (!in_array($type[1], $validTypes)) {
          $fileData['error'] = 'File type not valied';
          break;
        } elseif (filesize($_FILES[$fileId]['tmp_name'][$file]) > ($maxSize * 1024 * 1024)) {
          $fileData['error'] = 'Maximum file size exceeds';
          break;
        } else {
          $fileData[$fileId][$file] = uniqid($type[0] . '_') . '.' . $type[1];
          $fileData['path'][$file] = $_FILES[$fileId]['tmp_name'][$file];
          $fileData['error'] = 'NoError';
        }
      }
    }
  }
  // else {
  //   $fileData['error'] = 'File not found';
  // }
  return $fileData;
}

/*
function getFileNames()
{
  $fileNames = [];
  if (isset($_SESSION['uploadfilenames'])) {
    $fileNames = $_SESSION['uploadfilenames'];
    unset($_SESSION['uploadfilenames']);
  }
  return $fileNames;
}

function uploadFiles($fileCount, $targetPath, $validTypes, $maxSize = 1)
{
  if ($fileCount > count($_FILES)) {
    $fileCount = count($_FILES);
  }
  $maxSize = $maxSize * 1024 * 1024;
  $fileData = [
    'status' => [
      'state' => 'invalid',
      'msg' => ''
    ],
    'name' => []
  ];
  // var_dump(count($_FILES));
  unset($_SESSION['uploadfilenames']);

  if (!(count($_FILES) > 0)) {
    $fileData['status']['msg'] = 'File not found';
  }
  for ($file = 0; $file < $fileCount; $file++) {
    if ($_FILES[$file]['error'] > 0) {
      switch ($_FILES[$file]['error']) {
        case 1:
          $fileData['status']['msg'] = 'Max file size exceeds by server';
          break;
        case 2:
          $fileData['status']['msg'] = 'Max file size exceeds by client';
          break;
        case 3:
          $fileData['status']['msg'] = 'File not fully uploaded';
          break;
        case 4:
          $fileData['status']['msg'] = 'File not uploaded';
          break;
        case 6:
          $fileData['status']['msg'] = 'Missing a temporary folder';
          break;
        case 7:
          $fileData['status']['msg'] = 'Failed to write file to disk';
          break;
        case 8:
          $fileData['status']['msg'] = 'File upload stopped by extension';
          break;
        default:
          $fileData['status']['msg'] = 'Unknown upload error';
          break;
      }
      break;
    } else {
      $ext = explode('/', mime_content_type($_FILES[$file]['tmp_name']))[1];
      if (!in_array($ext, $validTypes)) {
        $fileData['status']['msg'] = 'File type not valied';
        break;
      } elseif (filesize($_FILES[$file]['tmp_name']) > $maxSize) {
        $fileData['status']['msg'] = 'Maximum file size exceeds';
        break;
      } else {
        $fileData['name'][$file] = uniqid() . '.' . $ext;
      }
    }
  }
  // if all files valid
  if (empty($fileData['status']['msg'])) {
    $fileData['status']['state'] = 'success';

    for ($file = 0; $file < $fileCount; $file++) {
      if (move_uploaded_file($_FILES[$file]['tmp_name'], $targetPath . $fileData['name'][$file])) {
        $_SESSION['uploadfilenames'][$file] = $fileData['name'][$file];
      } else {
        $fileData['status']['state'] = 'invalid';
        $fileData['status']['msg'] = 'File not saved';
      }
    }
  } else {
    unset($fileData['name']);
  }
  return $fileData['status'];
}
*/

/*
function validateFiles($fileCount, $validTypes, $maxSize = 1050000)
{
  if ($fileCount > count($_FILES)) {
    $fileCount = count($_FILES);
  }
  $fileStatus = [
    'err_msg' => '',
    'path' => [],
    'name' => []
  ];
  for ($file = 0; $file < $fileCount; $file++) {
    if ($_FILES[$file]['error'] > 0) {
      switch ($_FILES[$file]['error']) {
        case 1:
          $fileStatus['err_msg'] = 'Max file size exceeds by server';
          break;
        case 2:
          $fileStatus['err_msg'] = 'Max file size exceeds by client';
          break;
        case 3:
          $fileStatus['err_msg'] = 'File not fully uploaded';
          break;
        case 4:
          $fileStatus['err_msg'] = 'File not uploaded';
          break;
        case 6:
          $fileStatus['err_msg'] = 'Missing a temporary folder';
          break;
        case 7:
          $fileStatus['err_msg'] = 'Failed to write file to disk';
          break;
        case 8:
          $fileStatus['err_msg'] = 'File upload stopped by extension';
          break;
        default:
          $fileStatus['err_msg'] = 'Unknown upload error';
          break;
      }
      break;
    } else {
      $ext = explode('/', mime_content_type($_FILES[$file]['tmp_name']))[1];
      if (!in_array($ext, $validTypes)) {
        $fileStatus['err_msg'] = 'File type not valied';
        break;
      } elseif (filesize($_FILES[$file]['tmp_name']) > $maxSize) {
        $fileStatus['err_msg'] = 'Maximum file size exceeds';
        break;
      } else {
        $fileStatus['path'][$file] = $_FILES[$file]['tmp_name'];
        $fileStatus['name'][$file] = uniqid() . '.' . $ext;
      }
    }
  }
  return $fileStatus;
}
*/
/*
function validateFiles($fileCount, $validTypes, $maxSize = 1050000)
{
  if ($fileCount > count($_FILES)) {
    $fileCount = count($_FILES);
  }
  $fileStatus = [
    'state' => 'success',
    'msg' => '',
    'path' => [],
    'ext' => [],
    'name' => []
  ];
  for ($file = 0; $file < $fileCount; $file++) {
    if ($_FILES[$file]['error'] > 0) {
      switch ($_FILES[$file]['error']) {
        case 1:
          $fileStatus['msg'] = 'Max file size exceeds by server';
          break;
        case 2:
          $fileStatus['msg'] = 'Max file size exceeds by client';
          break;
        case 3:
          $fileStatus['msg'] = 'File not fully uploaded';
          break;
        case 4:
          $fileStatus['msg'] = 'File not uploaded';
          break;
        case 6:
          $fileStatus['msg'] = 'Missing a temporary folder';
          break;
        case 7:
          $fileStatus['msg'] = 'Failed to write file to disk';
          break;
        case 8:
          $fileStatus['msg'] = 'File upload stopped by extension';
          break;
        default:
          $fileStatus['msg'] = 'Unknown upload error';
          break;
      }
      $fileStatus['state'] = 'error';
      break;
    } else {
      $ext = explode('/', mime_content_type($_FILES[$file]['tmp_name']))[1];
      if (!in_array($ext, $validTypes)) {
        $fileStatus['msg'] = 'File type not valied';
        $fileStatus['state'] = 'error';
        break;
      } elseif (filesize($_FILES[$file]['tmp_name']) > $maxSize) {
        $fileStatus['msg'] = 'Maximum file size exceeds';
        $fileStatus['state'] = 'error';
        break;
      } else {
        $fileStatus['path'][$file] = $_FILES[$file]['tmp_name'];
        $fileStatus['ext'][$file] = $ext;
      }
    }
  }
  return $fileStatus;
}
*/