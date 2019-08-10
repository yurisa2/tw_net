<?php
namespace Twitterbot\Lib;

/**
 * Get all users that we are following (friends), check if given user is friend
 *
 * @param config:sUsername
 */
class Following extends Base
{
    private $aFollowing = false;

    /**
     * Get all friends (people we are following)
     *
     * @return bool
     */
    public function getAll()
    {
        $oRet = $this->oTwitter->get('friends/ids', array('screen_name' => $this->oConfig->get('sUsername'), 'stringify_ids' => true));
        if (!empty($oRet->errors[0]->message)) {
            $this->logger->write(2, sprintf('Twitter API call failed: GET friends/ids (%s)', $aMentions->errors[0]->message));
            $this->logger->output(sprintf('- Failed getting friends, halting. (%s)', $aMentions->errors[0]->message));

            return false;
        }

        $this->aFollowing = $oRet->ids;

        return true;
    }

    /**
     * Check if a given user is our friend (we follow them)
     *
     * @param object $oUser
     *
     * @return bool
     */
    public function isFollowing($oUser)
    {
        if (!is_array($this->aFollowing)) {
            $this->getAll();
        }

        return (in_array($oUser->id_str, $this->aFollowing));
    }
}
