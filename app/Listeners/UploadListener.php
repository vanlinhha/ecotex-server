<?php

namespace App\Listeners;

use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;
use Unisharp\Laravelfilemanager\Events\FolderWasRenamed;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;
use UniSharp\LaravelFilemanager\Events\ImageIsUploading;
use UniSharp\LaravelFilemanager\Events\ImageIsDeleting;
use UniSharp\LaravelFilemanager\Events\ImageIsRenaming;
use UniSharp\LaravelFilemanager\Events\FolderIsRenaming;
use App\Models\Cores\Cores_Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UploadListener
{

    public function handle($event)
    {
        $method = 'on' . class_basename($event);
        if (method_exists($this, $method))
        {
            call_user_func([$this, $method], $event);
        }
    }

    public function onImageIsUploading(ImageIsUploading $event)
    {
        
    }

    public function onImageIsDeleting(ImageIsDeleting $event)
    {
        $path           = $event->path();
        $base_directory = config('lfm.base_directory');
        $v_user_id      = Auth::user()->id;
        $pathfile       = str_replace('\\', '/', $path);
        $arrPathFile    = explode($base_directory, $pathfile);
        $pathfile       = end($arrPathFile);
        $pathfile       = trim($pathfile, '/');
        $count          = Cores_Media::where([
                    ['filepath', $pathfile],
                    ['user_id', $v_user_id],
                ])->count();
        if ($count > 0)
        {
            echo "Xóa tài liệu thất bại.Tài liệu đã được sử dụng không được phép xóa";
            die;
        }
    }

    public function onImageIsRenaming(ImageIsRenaming $event)
    {
        $path           = $event->oldPath();
        $base_directory = config('lfm.base_directory');
        $v_user_id      = Auth::user()->id;
        $pathfile       = str_replace('\\', '/', $path);
        $arrPathFile    = explode($base_directory, $pathfile);
        $pathfile       = end($arrPathFile);
        $pathfile       = trim($pathfile, '/');
        $count          = Cores_Media::where([
                    ['filepath', $pathfile],
                    ['user_id', $v_user_id],
                ])->count();
        if ($count > 0)
        {
            echo "Đổi tên tài liệu thất bại.Tài liệu đã được sử dụng không được phép đổi tên";
            die;
        }
    }

    public function onFolderIsRenaming(FolderIsRenaming $event)
    {
        $path           = $event->oldPath();
        $base_directory = config('lfm.base_directory');
        $v_user_id      = Auth::user()->id;
        $pathfile       = str_replace('\\', '/', $path);
        $arrPathFile    = explode($base_directory, $pathfile);
        $pathfile       = end($arrPathFile);
        $pathfile       = trim($pathfile, '/');
        $count          = Cores_Media::where([
                    ['user_id', $v_user_id],
                ])
                ->whereRaw("filepath like '%$pathfile%'")
                ->count();
        if ($count > 0)
        {
            echo "Đổi tên thư mục thất bại.Thư mục đã có tài liệu được sử dụng không được phép đổi tên";
            die;
        }
    }

}
