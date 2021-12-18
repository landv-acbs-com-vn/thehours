<?php
      function login_goole() {
            // Login Google Account
            $account = array(
                  'accountType' => 'GOOGLE',
                  'Email'       => '18521111@gm.uit.edu.vn',
                  'Password'    => '1467835302',
                  'source'      => __FILE__,
                  'service'     => 'lh2'
            );

            $connect = curl_init();
            curl_setopt($connect, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
            curl_setopt($connect, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($connect, CURLOPT_SSL_VERIFYPEER, 0);  
            curl_setopt($connect, CURLOPT_POST, true);  
            curl_setopt($connect, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1" );
            curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);  
            curl_setopt($connect, CURLOPT_POSTFIELDS, $account;  
            $hasil = curl_exec($connect);  

            // Check Connect to Google
            if (preg_match('#Auth=([a-z0-9_\-]+)#i'), $hasil, $match) {
                  return $match[1];
            }
            return false;

      }

      //  $path is link to image upload
      function upload_picasa($path, $accountID = '', $albumID = '') {
            $key = login_goole()

            // Check login
            if (!$key) {
                  return 'Cannot login to Google';
            }

            // URL to Album on Google Photo
            $albumUrl = "https://picasaweb.google.com/data/feed/api/user/$accountID/albumid/$albumID";

            // XML Upload of Google provide
            $rawImgXml = '<entry xmlns="http://www.w3.org/2005/Atom">
                              <title>ten_file_sau_khi_upload.jpg</title>
                              <summary>Mô tả file sau khi upload.</summary>
                              <category scheme="http://schemas.google.com/g/2005#kind"
                              term="http://schemas.google.com/photos/2007#photo"/>
                          </entry>';

            // Get information of the file
            $fileSize = filesize($path);
            $fh = fopen($path, 'rb');
            $imgData = fread($fh, $fileSize);
            fclose($fh);

            // Data header, cấu trúc được cung cấp bởi google
            $dataLength = strlen($rawImgXml) + $fileSize;
            $data = "";
            $data .= "\nMedia multipart posting\n";
            $data .= "--P4CpLdIHZpYqNn7\n";
            $data .= "Content-Type: application/atom+xml\n\n";
            $data .= $rawImgXml . "\n";
            $data .= "--P4CpLdIHZpYqNn7\n";
            $data .= "Content-Type: image/jpeg\n\n";
            $data .= $imgData . "\n";
            $data .= "--P4CpLdIHZpYqNn7--";
 
            $header = array(
                  'GData-Version:  2', 
                  'Authorization:  GoogleLogin auth="'.$key.'"', 
                  'Content-Type: multipart/related; boundary=P4CpLdIHZpYqNn7;', 
                  'Content-Length: ' . strlen($data), 'MIME-version: 1.0'
            );
 
            // Upload
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_URL, $albumUrl);  
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
            curl_setopt($ch, CURLOPT_POST, true);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
            curl_setopt($ch, CURLOPT_HEADER, true);  
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
 
            $ret = curl_exec($ch);
            curl_close($ch);
     
            // Xử lý kết quả trả về để lấy đường dẫn
            preg_match('#<gphoto:width>(\d+)</gphoto:width>#', $ret, $match);
            $width = $match[1];
            preg_match('#<gphoto:height>(\d+)</gphoto:height>#', $ret, $match);
            $height = $match[1];
            preg_match('#src=\'([^\'"]+)\'#', $ret, $match);
            $url = $match[1];
            
            $size = max($width, $height);
            $url = str_replace(basename($url), 's' . $size . '/' . basename($url), $url);
     
            return $url;
      }

?>