<?php
      require_once './vendor/autoload.php';
      use Google\Client;
      use Google\Service\Drive;
      # TODO - PHP client currently chokes on fetching start page token
      function uploadBasic()
      {
            try {
                  $client = new Client();
                  putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials.json');
                  $client->useApplicationDefaultCredentials();
                  $client->addScope(Drive::DRIVE);
                  $driveService = new Drive($client);

                  $file = getcwd().'/index.jpeg';
                  $filename = basename($file);
                  $mimetype = mime_content_type($filename);

                  $fileMetadata = new Drive\DriveFile(array(
                        'name' => $filename,
                        'parents' => ['17R3oWgmRwjDipKxpavzShJX8-d_dJAkY']
                  ));
                  $content = file_get_contents('./index.jpeg');
                  $file = $driveService->files->create($fileMetadata, array(
                        'data' => $content,
                        'mimeType' => $mimetype,
                        'uploadType' => 'multipart',
                        'fields' => 'id'));
                  printf("File ID: %s\n", $file->id);
                  return $file->id;
            } catch(Exception $e) {
                  echo "Error Message: ".$e;
            } 
      
      }

      uploadBasic();