<?php
namespace Twitterbot\Lib;

use Twitterbot\Custom\Imgur;

/**
 * Format class - formats objects into a tweet according to settings
 *
 * TODO: the tweet_vars.x.attach_image field is not checked, instead hardcoding it based on content type
 * TODO: any attached content isn't removed from the tweet
 * @TODO: https://imgur.com/tdXKAgN isn't correctly parsed
 * @TODO: optionally add ellipsis when truncating field
 *
 * @param config:source - database/rss where record came from, needed for handling format settings
 * @param config:max_tweet_length
 * @param config:short_url_length
 * @param config:tweet_vars - variables present in tweet and their values
 * @param config:format - unformatted tweet string
 * @param config:allow_mentions - allow tweets to mention other users
 */
class Format extends Base
{
    /**
     * Format record object as a database or rss item (wrapper)
     *
     * @param object $oRecord
     *
     * @return string
     */
    public function format($oRecord)
    {
        if (is_array($oRecord)) {
            $oRecord = (object) $oRecord;
        }

        switch ($this->oConfig->get('source')) {
            case 'database':
            default:

                return $this->db_format($oRecord);

            case 'rss':
            case 'json':
            case 'other':

                return $this->rss_format($oRecord);
        }
    }

    /**
     * Format record object as an rss item according to tweet settings
     *
     * @param object $oRecord
     *
     * @return string
     */
    public function rss_format($oRecord)
    {
        $iMaxTweetLength = $this->oConfig->get('max_tweet_lengh', 280);
        $iShortUrlLength = $this->oConfig->get('short_url_length', 23);

        //format message according to format in settings, and return it
        $aTweetVars = $this->oConfig->get('tweet_vars');
        $sTweet = $this->oConfig->get('format');

        //replace all non-truncated fields
        foreach ($aTweetVars as $oTweetVar) {
            if (empty($oTweetVar->truncate) || $oTweetVar->truncate == false) {
                $sTweet = str_replace($oTweetVar->var, $this->getRssValue($oRecord, $oTweetVar), $sTweet);
            }
        }

        //disable mentions if needed
        if (!$this->oConfig->get('allow_mentions', false)) {
            $sTweet = str_replace('@', '#', $sTweet);
        }

        //determine maximum length left over for truncated field (links are shortened to t.co format of max 22 chars)
        $sTempTweet = preg_replace('/http:\/\/\S+/', str_repeat('x', $iShortUrlLength), $sTweet);
        $sTempTweet = preg_replace('/https:\/\/\S+/', str_repeat('x', $iShortUrlLength + 1), $sTempTweet);
        $iTruncateLimit = $iMaxTweetLength - strlen($sTempTweet);

        //replace truncated field
        foreach ($aTweetVars as $oTweetVar) {
            if (!empty($oTweetVar->truncate) && $oTweetVar->truncate == true) {

                //placeholder will get replaced, so add that to char limit
                $iTruncateLimit += strlen($oTweetVar->var);

                //get text to replace placeholder with
                $sText = html_entity_decode($this->getRssValue($oRecord, $oTweetVar), ENT_QUOTES, 'UTF-8');

                //disable mentions if needed
                if (!$this->oConfig->get('allow_mentions', false)) {
                    $sText = str_replace('@', '#', $sText);
                }

                //get length of text with url shortening
                $sTempText = preg_replace('/http:\/\/\S+/', str_repeat('x', $iShortUrlLength), $sText);
                $sTempText = preg_replace('/https:\/\/\S+/', str_repeat('x', $iShortUrlLength + 1), $sTempText);
                $iTextLength = strlen($sTempText);

                //if text with url shortening falls under limit, keep it - otherwise truncate
                if ($iTextLength <= $iTruncateLimit) {
                    $sTweet = str_replace($oTweetVar->var, $sText, $sTweet);
                } else {
                    $sTweet = str_replace($oTweetVar->var, substr($sText, 0, $iTruncateLimit), $sTweet);
                }

                //only 1 truncated field allowed
                break;
            }
        }

        return trim($sTweet);
    }

    /**
     * Format record object as a database record, according to tweet settings
     *
     * @param array $aRecord
     *
     * @return string
     */
    public function db_format($aRecord)
    {
        $iMaxTweetLength = $this->oConfig->get('max_tweet_lengh', 280);
        $iShortUrlLength = $this->oConfig->get('short_url_length', 23);

        //format message according to format in settings, and return it
        $aTweetVars = $this->oConfig->get('tweet_vars', []);
        $sTweet = $this->oConfig->get('format');

        //replace all non-truncated fields
        foreach ($aTweetVars as $oTweetVar) {
            if (empty($oTweetVar->truncate) || $oTweetVar->truncate == false) {
                $sTweet = str_replace($oTweetVar->var, $aRecord->{$oTweetVar->recordfield}, $sTweet);
            }
        }

        //disable mentions if needed
        if (!$this->oConfig->get('allow_mentions', false)) {
            $sTweet = str_replace('@', '#', $sTweet);
        }

        //determine maximum length left over for truncated field (links are shortened to t.co format of max 22 chars)
        $sTempTweet = preg_replace('/http:\/\/\S+/', str_repeat('x', $iShortUrlLength), $sTweet);
        $sTempTweet = preg_replace('/https:\/\/\S+/', str_repeat('x', $iShortUrlLength + 1), $sTempTweet);
        $iTruncateLimit = $iMaxTweetLength - strlen($sTempTweet);

        //replace truncated field
        foreach ($aTweetVars as $oTweetVar) {
            if (!empty($oTweetVar->truncate) && $oTweetVar->truncate == true) {

                //placeholder will get replaced, so add that to char limit
                $iTruncateLimit += strlen($oTweetVar->var);

                //get text to replace placeholder with
                $sText = html_entity_decode($aRecord->{$oTweetVar->recordfield}, ENT_QUOTES, 'UTF-8');

                //disable mentions if needed
                if (!$this->oConfig->get('allow_mentions', false)) {
                    $sText = str_replace('@', '#', $sText);
                }

                //get length of text with url shortening
                $sTempText = preg_replace('/http:\/\/\S+/', str_repeat('x', $iShortUrlLength), $sText);
                $sTempText = preg_replace('/https:\/\/\S+/', str_repeat('x', $iShortUrlLength + 1), $sTempText);
                $iTextLength = strlen($sTempText);

                //if text with url shortening falls under limit, keep it - otherwise truncate
                if ($iTextLength <= $iTruncateLimit) {
                    $sTweet = str_replace($oTweetVar->var, $sText, $sTweet);
                } else {
                    $sTweet = str_replace($oTweetVar->var, substr($sText, 0, $iTruncateLimit), $sTweet);
                }

                //only 1 truncated field allowed
                break;
            }
        }

        return $sTweet;
    }

    /**
     * Get value of variable from rss object according to tweet setting object
     *
     * @param object $oRecord
     * @param object $oValue
     *
     * @return mixed 
     */
    private function getRssValue($oRecord, $oValue)
    {
        if (strpos($oValue->value, 'special:') === 0) {
            return $this->getRssSpecialValue($oRecord, $oValue);
        }

        $mReturn = $oRecord;
        foreach (explode('>', $oValue->value) as $sNode) {
            if (isset($mReturn->$sNode)) {
                $mReturn = $mReturn->$sNode;
            } else {
                $mReturn = (!empty($oValue->default) ? $oValue->default : '');
                break;
            }
        }

        //if a regex is set, apply that to return value and return only first captured match
        if (!empty($oValue->regex)) {
            if (preg_match($oValue->regex, $mReturn, $aMatches)) {
                $mReturn = (!empty($aMatches[1]) ? $aMatches[1] : $mReturn);
            }
        }

        //if a prefix is set, add that to the return value
        if (!empty($oValue->prefix)) {
            $mReturn = $oValue->prefix . $mReturn;
        }

        return $mReturn;
    }

    /**
     * Get site-specific value of variable from record object according to tweet setting object
     * For reddit:mediatype, this will return the type of media, and upload the media to twitter if possible to attach to tweet
     *
     * @param object $oRecord
     * @param object $oValue
     *
     * @return string
     */
    private function getRssSpecialValue($oRecord, $oValue)
    {
        foreach ($this->oConfig->get('tweet_vars') as $oVar) {
            if ($oVar->var == $oValue->subject) {
                $sSubject = $this->getRssValue($oRecord, $oVar);
                break;
            }
        }
        if (empty($sSubject)) {
            $this->logger->write(1, sprintf('getRssSpecialValue failed: subject not found! %s', $oValue->subject));
            $this->logger->output('getRssSpecialValue failed: subject not found! %s', $oValue->subject);
            return false;
        }


        $this->sAttachFile = false;
        $bAttachFile = false;

        switch($oValue->value) {
            case 'special:redditmediatype':
                //determine linked resource type (reddit link, external, image, gallery, etc)

                if (strpos($sSubject, $oRecord->data->permalink) !== false) {
                    //if post links to itself, text post (no link)
                    $sResult = 'self';

                } elseif (preg_match('/reddit\.com/i', $sSubject)) {
                    //link to other subreddit
                    $sResult = 'crosslink';

                } elseif (preg_match('/\.png|\.gif$|\.jpe?g/i', $sSubject)) {
                    //naked image
                    $sResult = 'image';
                    $bAttachFile = true;

                } elseif (preg_match('/imgur\.com\/.[^\/]/i', $sSubject) || preg_match('/imgur\.com\/gallery\//i', $sSubject)) {
                    //single image on imgur.com page
                    $sResult = 'image';
                    $bAttachFile = true;

                } elseif (preg_match('/reddituploads\.com/i', $sSubject)) {
                    //reddit hosted file
                    $sResult = 'image';
                    $bAttachFile = true;

                    //ampersands seem to get mangled in posting, messing up the checksum
                    $sSubject = str_replace('&amp;', '&', $sSubject);

                } elseif (preg_match('/imgur\.com\/a\//i', $sSubject)) {
                    //imgur.com album, possibly with multiple images
                    $bAttachFile = true;

                    //use imgur API here to get number of images in album, set type to [album:n]
                    if (($iImageCount = (new Imgur)->getAlbumImageCount($sSubject)) && is_numeric($iImageCount) && $iImageCount > 1) {
                        $sResult = sprintf('album:%d', $iImageCount);
                    } else {
                        $sResult = 'album';
                    }
                } elseif (preg_match('/instagram\.com\/.[^\/]/i', $sSubject) || preg_match('/instagram\.com\/p\//i', $sSubject)) {
                    //instagram account link or instagram photo
                    $sResult = 'instagram';
                    $bAttachFile = true;

                } elseif (preg_match('/gfycat\.com\//i', $sSubject)) {
                    //gfycat short video (no sound)
                    $sResult = 'gif';
                    $bAttachFile = true;

                } elseif (preg_match('/\.gifv|\.webm|youtube\.com\/|youtu\.be\/|vine\.co\/|vimeo\.com\/|liveleak\.com\//i', $sSubject)) {
                    //common video hosting websites
                    $sResult = 'video';

                } elseif (preg_match('/pornhub\.com|xhamster\.com/i', $sSubject)) {
                    //porn video hosting websites
                    $sResult = 'video';

                } else {
                    $sResult = 'link';
                }

                break;
        }

        $this->aAttachment = [];
        if ($bAttachFile) {
            $this->aAttachment = array(
                'type' => $sResult,
                'url' => $sSubject,
            );
        }

        return $sResult;
    }

    /**
     * Get file to attach to tweet, if any
     *
     * @return array
     */
    public function getAttachment()
    {
        return (!empty($this->aAttachment) ? $this->aAttachment : false);
    }
}
