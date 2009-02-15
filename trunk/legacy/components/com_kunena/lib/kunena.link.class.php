<?php
/**
* @version $Id$
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2009 Kunena Team All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.kunena.com
*
* Based on FireBoard Component
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
**/

// Dont allow direct linking
defined ('_VALID_MOS') or die('Direct Access to this location is not allowed.');

class CKunenaLink
{
    //
    // Basic universal href link
    //
    function GetSefHrefLink($link, $name, $title, $rel, $class ='', $anker='', $attr='')
    {
    	// For Joomla 1.0.x SEF compatibility we must add the anker after the SEF translation or it gets stripped
        return '<a '.($class ? 'class="'.$class.'" ' : '').'href="'.sefRelToAbs($link).($anker?('#'.$anker):'').'" title="'.$title.'"'.($rel ? ' rel="'.$rel.'"' : '').($attr ? ' '.$attr : '').'>'.$name.'</a>';
    }

    // Simple link is a barebones href link used for e.g. Jscript links
    function GetSimpleLink($id, $name='')
    {
        return'<a href="'.$id.'">'.$name.'</a>';
    }

    //
    // Central Consolidation of all internal href links
    //

    function GetCreditsLink()
    {
        return CKunenaLink::GetSefHrefLink('http://www.kunena.com', 'Kunena', 'Kunena', 'follow');
    }

    function GetTeamCreditsLink($catid, $name='')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=credits&amp;catid='.$catid, $name, '', 'follow');
    }

    function GetKunenaLink($name , $rel='follow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL, $name, '', $rel);
    }

    function GetRSSLink($name , $rel='follow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=fb_rss&amp;no_html=1', $name, '', $rel, '', '', 'target="_blank"');
    }

    function GetCategoryLink($func, $catid, $catname, $rel='follow', $class='')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;catid='.$catid, $catname, '', $rel, $class);
    }

    function GetCategoryListLink($name, $rel='follow', $class='')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=listcat', $name, '', $rel, $class);
    }

    function GetCategoryPageLink($func, $catid, $page, $pagename, $rel='follow', $class='')
    {
        if ($page == 1 || !is_numeric($page))
        {
            // page 1 is identical to a link to the regular category link
            $pagelink  = CKunenaLink::GetCategoryLink($func, $catid, $pagename, $rel, $class);
        }
        else
        {
            $pagelink  = CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;catid='.$catid.'&amp;page='.$page, $pagename, '', $rel, $class);
        }

        return $pagelink;
    }

    function GetCategoryReviewListLink($catid, $catname, $rel='nofollow', $class='')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=review&amp;action=list&amp;catid='.$catid, $catname, '', $rel, $class);
    }

    function GetThreadLink($func, $catid, $threadid, $threadname, $title, $rel='follow', $class='')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;catid='.$catid.'&amp;id='.$threadid, $threadname, $title, $rel, $class);
    }

    function GetThreadPageLink($fbConfig, $func, $catid, $threadid, $page, $limit, $name, $anker='', $rel='follow', $class='')
    {
        if ($page == 1 || !is_numeric($page) || !is_numeric($limit))
        {
            // page 1 is identical to a link to the top of the thread
            $pagelink  = CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;catid='.$catid.'&amp;id='.$threadid,
            										$name, '', $rel, $class, $anker);
        }
        else
        {
            $pagelink  = CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;catid='.$catid.'&amp;id='.$threadid
                          .'&amp;limit='.$limit.'&amp;limitstart='.(($page-1)*$limit), $name, '', $rel, $class, $anker);
        }

        return $pagelink;
    }

    // GetThreadPageURL is basically identically to the prior function except that it returns a clear text
    // non-encoded URL. This functions is used by the email function to notify users about new posts.
    function GetThreadPageURL($fbConfig, $func, $catid, $threadid, $page, $limit, $anker='')
    {
        if ($page == 1 || !is_numeric($page) || !is_numeric($limit))
        {
            // page 1 is identical to a link to the top of the thread
            $pageURL = htmlspecialchars_decode(KUNENA_LIVEURLREL).'&func='.$func.'&catid='.$catid.'&id='.$threadid;
        }
        else
        {
            $pageURL = htmlspecialchars_decode(KUNENA_LIVEURLREL).'&func='.$func.'&catid='.$catid.'&id='.$threadid
                          .'&limit='.$limit.'&limitstart='.(($page-1)*$limit);
        }

        return sefRelToAbs($pageURL).($anker?('#'.$anker):'');
    }

    function GetSamePageAnkerLink($anker, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(htmlspecialchars(sefRelToAbs('index.php?'.$_SERVER['QUERY_STRING'])), $name, '', $rel, '', $anker);
    }

    function GetReportMessageLink($catid, $msg_id, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=report&amp;catid='.$catid.'&amp;msg_id='.$msg_id, $name, '', $rel);
    }

    function GetMessageIPLink($msg_ip, $rel='nofollow')
    {
        if ($msg_ip)
        {
            $iplink = '<a href="http://openrbl.org/dnsbl?i='.$msg_ip.'&amp;f=2" target="_blank">';
            $iplink .= 'IP: '.$msg_ip.'</a>';
        }
        else
        {
            $iplink = '&nbsp;';
        }

        return $iplink;
    }

    function GetMyProfileLink($fbConfig, $userid, $name, $rel='nofollow')
    {
    	if($fbConfig->fb_profile == 'jomsocial' || $fbConfig->fb_profile == 'cb')
    	{
    		return CKunenaLink::GetProfileLink($fbConfig, $userid, $name, $rel);
    	}
    	else
    	{
    		return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=myprofile&amp;do=show', $name, '', $rel);
    	}
    }

    function GetProfileLink($fbConfig, $userid, $name, $rel='nofollow', $class='')
    {
    	// Only create links for valid users
    	if ($userid > 0)
    	{
   			return CKunenaLink::GetSefHrefLink(KUNENA_PROFILE_LINK_SUFFIX.$userid, $name, '', $rel, $class);
    	}
    	else // supress links for guests
    	{
    		return $name;
    	}
    }


    function GetViewLink($func, $id, $catid, $view, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;id='.$id.'&amp;view='.$view.'&amp;catid='.$catid, $name, '', $rel);
    }

    function GetPendingMessagesLink($catid, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=review&action=list&amp;catid='.$catid, $name, '', $rel);
    }

    function GetShowLatestLink($name, $rel='follow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=latest', $name, '', $rel);
    }

    function GetShowLatestURL()
    {
        return sefRelToAbs(KUNENA_LIVEURLREL.'&amp;func=latest');
    }

    function GetShowMyLatestLink($name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=mylatest', $name, '', $rel);
    }

    function GetShowLatestThreadsLink($period, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=latest&amp;do=show&amp;sel='.$period, $name, '', $rel);
    }

    // Function required to support default_ex template
    function GetLatestPageLink($func, $page, $rel='follow', $class='', $sel='')
    {
    	// if ($func=='') $func = 'latest';
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func='.$func.'&amp;page='.$page.(($sel)?'&amp;sel='.$sel:''), $page, '', $rel, $class);
    }

    function GetPostNewTopicLink($catid, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=post&amp;do=reply&amp;catid='.$catid, $name, '', $rel);
    }

    function GetTopicPostLink($do, $catid, $id, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=post&amp;do='.$do.'&amp;catid='.$catid.'&amp;id='.$id, $name, '', $rel);
    }

    function GetTopicPostReplyLink($do, $catid, $id, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=post&amp;do='.$do.'&amp;catid='.$catid.'&amp;replyto='.$id, $name, '', $rel);
    }

    function GetEmailLink($email, $name)
    {
        return CKunenaLink::GetSimpleLink('mailto:'.stripslashes($email), stripslashes($name));
    }

    function GetKarmaLink($do, $catid, $pid, $userid, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=karma&amp;do='.$do.'&amp;userid='.$userid.'&amp;pid='.$pid.'&amp;catid='.$catid, $name, '', $rel);
    }

    function GetRulesLink($fbConfig, $name, $rel='nofollow')
    {
        $ruleslink = $fbConfig->rules_infb ? KUNENA_LIVEURLREL.'&amp;func=rules' : $fbConfig->rules_link;
        return CKunenaLink::GetSefHrefLink($ruleslink, $name, '', $rel);
    }

    function GetHelpLink($fbConfig, $name, $rel='nofollow')
    {
        $helplink = $fbConfig->help_infb ? KUNENA_LIVEURLREL.'&amp;func=faq' : $fbConfig->help_link;
        return CKunenaLink::GetSefHrefLink($helplink, $name, '', $rel);
    }

    function GetSearchLink($fbConfig, $searchword, $start, $name, $rel='nofollow')
    {
        return CKunenaLink::GetSefHrefLink(KUNENA_LIVEURLREL.'&amp;func=search&amp;searchword=' . $searchword . '&amp;start='.$start, $name, '', $rel);
    }

    //
    // Macro functions that build more complex html output with embedded links
    //

    //
    // This function builds the auto redirect block to go back to the latest post of a particular thread
    // It is used for various operations. Input parameter is any post id. It will determine the thread,
    // latest post of that thread and number of pages based on the supplied page limit.
    //
    function GetLatestPostAutoRedirectHTML($fbConfig, $pid, $limit)
    {
        global $database;
        // First determine the thread, latest post and number of posts for the post supplied
        $database->setQuery('SELECT a.thread AS thread, max(a.id) AS latest_id, max(a.catid) AS catid, count(*) AS totalmessages
                             FROM #__fb_messages AS a,
                                (SELECT max(thread) AS thread FROM #__fb_messages WHERE id='.$pid.') AS b
                             WHERE a.thread = b.thread AND a.hold = 0
                             GROUP BY a.thread');
        $database->loadObject($result);
        	check_dberror("Unable to retrieve latest post.");

        // Now Calculate the number of pages for this particular thread
        $threadPages = ceil($result->totalmessages / $limit);

        // Finally build output block

        $Output  = '<div align="center">';
        $Output .= CKunenaLink::GetThreadPageLink($fbConfig, 'view', $result->catid, $result->thread, $threadPages, $limit, _POST_SUCCESS_VIEW, $result->latest_id) .'<br />';
        $Output .= CKunenaLink::GetCategoryLink('showcat', $result->catid, _POST_SUCCESS_FORUM).'<br />';
        $Output .= '</div>';
        $Output .= CKunenaLink::GetAutoRedirectHTML(CKunenaLink::GetThreadPageURL($fbConfig, 'view', $result->catid, $result->thread, $threadPages, $limit, $result->latest_id), 3500);

        return $Output;
    }

    function GetLatestCategoryAutoRedirectHTML($catid)
    {
        $Output  = '<div id="Kunena_post_result" align="center">';
        $Output .= CKunenaLink::GetCategoryLink('showcat', $catid, _POST_SUCCESS_FORUM).'<br />';
        $Output .= '</div>';
        $Output .= CKunenaLink::GetAutoRedirectHTML(KUNENA_LIVEURLREL . '&func=showcat&catid=' . $catid, 3500);

        return $Output;
    }

    function GetAutoRedirectHTML($url, $timeout)
    {
	$url = htmlspecialchars_decode($url);
        $Output = "\n<script type=\"text/javascript\">\n// <![CDATA[\n";
        $Output .= "kunenaRedirectTimeout('$url', $timeout);";
        $Output .= "\n// ]]>\n</script>\n";

        return $Output;
    }
}
?>
