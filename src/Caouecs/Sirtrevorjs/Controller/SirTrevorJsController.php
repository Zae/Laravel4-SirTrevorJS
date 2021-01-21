<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Controller;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use \Illuminate\Routing\Controller;

use function is_null;

/**
 * Controller Sir Trevor Js
 * - upload image
 * - display tweet.
 */
class SirTrevorJsController extends Controller
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * SirTrevorJsController constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Upload image.
     *
     * you can define `directory_upload` in config file
     *
     * @param Request $request
     */
    public function upload(Request $request): void
    {
        if ($request->hasFile('attachment')) {
            // config
            $config = $this->config->get('sirtrevorjs::sir-trevor-js');

            // file
            $file = $request->file('attachment');

            // Problem on some configurations
            $file = (!method_exists($file, 'getClientOriginalName') && isset($file['file'])) ? $file['file'] : $file;

            if (!$file instanceof UploadedFile) {
                return;
            }

            // filename
            $filename = $file->getClientOriginalName();

            // suffix if file exists
            $suffix = '01';

            // verify if file exists
            while (file_exists(public_path($config['directory_upload']) . '/' . $filename)) {
                $filename = $suffix . '_' . $filename;

                /**
                 * @psalm-suppress StringIncrement
                 */
                $suffix++;

                if ($suffix < 10) {
                    $suffix = '0' . $suffix;
                }
            }

            if ($file->move(public_path($config['directory_upload']), $filename)) {
                $return = [
                    'file' => [
                        'url' => '/' . $config['directory_upload'] . '/' . $filename,
                    ],
                ];

                echo json_encode($return);
            }
        }
    }
}
