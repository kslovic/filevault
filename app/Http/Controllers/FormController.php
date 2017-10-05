<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Asset;
use Illuminate\Http\Request;

class FormController extends Controller
{
    //homepage - get last 10 assets from current user - if !guest
    public function index()
    {
        if (!Auth::guest()) {
            $assets = Asset::where('uid', Auth::user()->id)->orderby('pub_time','desc')->simplePaginate(10);
            $assets->setPath('/page');
            return view('homepage', ['asset' => $assets]);
        } else {
            return Redirect::to('/login');
        }
    }

    //check file - validate, get attributes, size<25MB, create new Asset
    public function upload(Request $request)
    {
        if (!Auth::guest()) {
            $uid = Auth::user()->id;
            $message = "Choose file...";
            if ($request->has('upload')) {
                if ($request->file('upload')->isValid()) {
                    $file = $request->upload;
                    $name = $file->getClientOriginalName();
                    $mime_type = $file->getMimeType();
                    $size = $file->getClientSize() / (1024 * 1024);
                    if ($size <= 25) {
                        $path = $file->store('images');

                        $asset = new Asset();

                        $asset->title = $name;
                        $asset->mime_type = $mime_type;
                        $asset->ref = $path;
                        $asset->size = $file->getClientSize();
                        if ($request->public)
                            $asset->public = "yes";
                        $asset->uid = $uid;

                        $asset->save();

                        $message = "File upload was successful";
                    } else {
                        $message = "File is too large";
                    }

                }
            }
            $assets = Asset::where('uid', $uid)->orderby('pub_time','desc')->simplePaginate(10);
            return view('homepage', ['asset' => $assets,'message' => $message]);
        } else {
            return Redirect::to('/login');
        }
    }

    //check user status - guest|!guest , check asset premission - public|private, update db-downloaded, return response -download
    public function download($aid)
    {
        $asset = Asset::where('aid', $aid)->get();
          foreach ($asset as $asset) {
                if (Auth::guest()&&$asset->public == "no"||!Auth::guest()&&$asset->public == "no" && $asset->uid != Auth::user()->id) {
                    $message = "You have no premission to download this file !!!";
                    return $message;
                } else {
                    Asset::where('aid',$asset->aid)->update(['downloaded' => $asset->downloaded + 1]);
                    return response()->download(storage_path('app/' . $asset->ref));
                }
            }

    }

    //return to js: message - download fail|success, downloaded -quanity
    public function downloadshow($aid){
        $asset = Asset::where('aid', $aid)->get();
        if (!Auth::guest()) {
            $uid = Auth::user()->id;
            foreach ($asset as $asset) {
                if ($asset->public == "no" && $asset->uid != $uid) {
                    $message = "You have no premission to download this file !!!";
                    return array('value' => $asset->downloaded, 'message' => $message);
                } else {
                    $message = "Success! File downloaded";
                    return array('value' => $asset->downloaded + 1, 'message' => $message);
                }
            }
        }
    }

    //check user premission and update file premission
    public function edit($aid)
    {
        if (!Auth::guest()) {
                $uid = Auth::user()->id;
                $asset = Asset::where('aid', $aid)->get();
                $message = "Product not found";
                $value = "no";
                foreach ($asset as $asset) {
                    if ($asset->public == "no" && $asset->uid != $uid) {
                        $message = "You have no premission to edit this file !!!";
                    } else {
                        $message = "Premission changed !!!";
                        if ($asset->public == "yes") {
                            Asset::where('aid', $aid)->update(['public' => "no"]);
                        } else {
                            Asset::where('aid', $aid)->update(['public' => "yes"]);
                            $value = "yes";
                        }
                    }
                }

                return array('value' => $value, 'message' => $message);

        } else {
            return Redirect::to('/login');
        }

    }

    //return assets matched with search term on multiple pages - pagination links
    public function searchajax($arg)
    {
        if (!Auth::guest()) {
            $uid = Auth::user()->id;
            $assets =Asset::where('uid', $uid)->where('title', 'like', '%' . $arg . '%')->orderby('pub_time', 'desc')->simplePaginate(10);
            $assets->setPath('/searchajax/'.$arg);
            return view('assets', ['asset' => $assets]);
        } else {
            return Redirect::to('/login');
        }
    }

    // new paginator page - return assets
    function page(){
        if (!Auth::guest()) {
            $uid = Auth::user()->id;
            $assets = Asset::where('uid', $uid)->orderby('pub_time', 'desc')->simplePaginate(10);
            return view('assets', ['asset' => $assets]);
        } else {
            return Redirect::to('/login');
        }
    }
}