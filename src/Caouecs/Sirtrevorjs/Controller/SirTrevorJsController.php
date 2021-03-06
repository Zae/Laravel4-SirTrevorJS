<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Controller;

use Thujohn\Twitter\TwitterFacade as Tweet;
use Config;
use Input;
use Controller;

/**
 * Controller Sir Trevor Js
 * - upload image
 * - display tweet
 *
 * @package Caouecs\Sirtrevorjs
 */
class SirTrevorJsController extends Controller
{
    /**
     * Upload image
     *
     * you can define `directory_upload` in config file
     *
     * @access public
     * @return string Data for Sir Trevor or Error
     */
    public function upload()
    {
        if (isset($_FILES["attachment"])) {
            // config
            $config = Config::get("sirtrevorjs::sir-trevor-js");

            // filename
            $filename = $_FILES['attachment']['name']['file'];

            // suffixe if file exists
            $suffixe = "01";

            // verif if file exists
            while (file_exists(public_path($config['directory_upload'])."/".$filename)) {
                $filename = $suffixe."_".$filename;

                $suffixe++;

                if ($suffixe < 10) {
                    $suffixe = "0".$suffixe;
                }
            }

            if (move_uploaded_file(
                $_FILES["attachment"]["tmp_name"]['file'],
                public_path($config['directory_upload'])."/".$filename
            )) {
                $return = array(
                    "file" => array(
                        "url" => "/".$config['directory_upload']."/".$filename
                    )
                );

                echo json_encode($return);
            }
        }
    }

    /**
     * Tweet
     *
     * @access public
     * @return string
     */
    public function tweet()
    {
        $input = Input::all();

        $tweet_id = isset($input['tweet_id']) ? e($input['tweet_id']) : null;

        if (empty($tweet_id)) {
            return null;
        }

        $tweet = Tweet::getTweet($tweet_id);

        if ($tweet !== false && !empty($tweet)) {
            $return = array(
                "id_str"     => $tweet_id,
                "text"       => $tweet->text,
                "created_at" => $tweet->created_at,
                "user"       => array(
                    "name"                    => $tweet->user->name,
                    "screen_name"             => $tweet->user->screen_name,
                    "profile_image_url"       => $tweet->user->profile_image_url,
                    "profile_image_url_https" => $tweet->user->profile_image_url_https
                )
            );

            echo json_encode($return);
        }
    }
}
