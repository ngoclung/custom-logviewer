<?php
namespace Rap2hpoutre\LaravelLogViewer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Common\CustomLogViewer;

class LogViewerController extends Controller
{

    public function index()
    {
        if (Request::input('l')) {
            CustomLogViewer::setFile(base64_decode(Request::input('l')));
        }
        
        if (Request::input('dl')) {
            return Response::download(CustomLogViewer::pathToLogFile(base64_decode(Request::input('dl'))));
        } elseif (Request::has('del')) {
            File::delete(CustomLogViewer::pathToLogFile(base64_decode(Request::input('del'))));
            return Redirect::to(Request::url());
        }
        
        $logs = CustomLogViewer::all();
        
        return View::make('laravel-log-viewer::log', [
            'logs' => $logs,
            'files' => CustomLogViewer::getFiles(true),
            'current_file' => CustomLogViewer::getFileName()
        ]);
    }
}

