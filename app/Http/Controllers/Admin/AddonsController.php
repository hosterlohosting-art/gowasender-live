<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Dotenv;
use Http;
use File;
use ZipArchive;
use Session;
class AddonsController extends Controller
{
    use Dotenv;

    public function __construct(){
      $this->middleware('permission:developer-settings'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.addons.index');
    }

    

    /**
     * check new update.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $siteKey = $request->purchase_key;
    $body['purchase_key'] = $siteKey;
    $body['url'] = url('/');
    $body['addoncode'] = $request->addoncode;
    $body['version'] = $request->version;
    
    $response = Http::get('', $body);

    if ($response->status() == 200) {
        $updateData = json_decode($response->body(), true);

        if (isset($updateData['zip_url'])) {
            $zipUrl = $updateData['zip_url'];
            $tempZipFile = storage_path('app/update.zip');
            $tempExtractPath = storage_path('app/extracted');

            // Download the update.zip file
            file_put_contents($tempZipFile, fopen($zipUrl, 'r'));

            // Extract the contents of the zip file
            $zip = new ZipArchive;
            if ($zip->open($tempZipFile) === TRUE) {
                $zip->extractTo($tempExtractPath);
                $zip->close();

                // Update the files and folders in the Laravel project
                $this->updateFilesAndFolders($tempExtractPath);

                // Clean up the temporary files and folders
                File::delete($tempZipFile);
                File::deleteDirectory($tempExtractPath);

                Session::flash('success', 'Successfully Activated');

                return response()->json([
                    'redirect' => url('/admin/addons'),
                ], 200);
            } else {
                // Error in extracting the zip file
                http_response_code(500);
                echo json_encode(['message' => 'Error extracting update.zip']);
                exit;
            }
        }
    }

    http_response_code(204); // No Content
    echo json_encode(['message' => 'No new update found.']);
    exit;
}

private function updateFilesAndFolders($sourcePath)
{
    $files = File::allFiles($sourcePath);
    $directories = File::directories($sourcePath);

    foreach ($files as $file) {
        $relativePath = str_replace($sourcePath, '', $file);
        $targetPath = base_path($relativePath);
        
        if (!is_dir(dirname($targetPath))) {
            mkdir(dirname($targetPath), 0755, true);
        }
        
        File::put($targetPath, File::get($file));
    }
    

    foreach ($directories as $directory) {
        $relativePath = str_replace($sourcePath, '', $directory);
        if (!File::exists(base_path($relativePath))) {
            File::makeDirectory(base_path($relativePath), 0755, true, true);
        }
    }
}
    
}
