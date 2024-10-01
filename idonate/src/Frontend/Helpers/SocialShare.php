<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 *
 */

namespace ThemeAtelier\Idonate\Frontend\Helpers;

// Blocking direct access
if (!defined('ABSPATH')) {
  die(esc_html(IDONATE_ALERT_MSG));
}
class SocialShare
{
  // share button code
  public static function idonate_social_sharing_buttons($name, $url, $donor_social_share)
  {
    $social_sharing_media = isset($donor_social_share['social_sharing_media']) ? $donor_social_share['social_sharing_media'] : '';
    $social_icon_shape = isset($donor_social_share['social_icon_shape']) ? $donor_social_share['social_icon_shape'] : '';

    // Get page URL 

    if (!empty($url)) {
      $URL = $url;
    } else {
      $URL = get_permalink();
    }

    $Sitetitle = get_bloginfo('name');
    // Get page title

    if (!empty($name)) {
      $Title = $name;
    } else {
      $Title = str_replace(' ', '%20', get_the_title());
    }

?>
    <div class="donor_social_share">
      <?php
      do_action('idonate_add_first_socials');
      if (!empty($social_sharing_media)) {
        foreach ($social_sharing_media as $style_key => $style_value) {
          switch ($style_value) {
            case 'facebook':
      ?>
              <a title="<?php echo esc_attr('Facebook', 'idonate') ?>" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($URL); ?>" class="idonate-social-icon idonate-facebook <?php echo esc_attr($social_icon_shape); ?>" onClick="window.open('https://www.facebook.com/sharer.php?u=<?php echo esc_url($URL); ?>','Facebook','width=450,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;"><i class="icofont-facebook"></i></a>
            <?php
              break;
            case 'twitter':
            ?>
              <a title="<?php echo esc_attr('Twitter', 'idonate') ?>" onClick="window.open('https://twitter.com/share?url=<?php echo esc_url($URL); ?>&amp;text=<?php echo esc_attr($Title); ?>','Twitter share','width=450,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="https://twitter.com/share?url=<?php echo esc_url($URL); ?>&amp;text=<?php echo esc_attr($Title); ?>" class="idonate-social-icon idonate-twitter <?php echo esc_attr($social_icon_shape); ?>"> <i class="icofont-twitter"></i></a>
            <?php
              break;
            case 'linkedIn':
            ?>
              <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($URL); ?>" title="<?php echo esc_attr('linkedIn', 'idonate') ?>" class="idonate-social-icon idonate-linkedin <?php echo esc_attr($social_icon_shape); ?>" onClick="window.open('https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($URL); ?>','Linkedin','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($URL); ?>"> <i class="icofont-linkedin"></i></a>
            <?php
              break;
            case 'pinterest':
            ?>
              <a href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;https://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());' class="idonate-social-icon idonate-pinterest <?php echo esc_attr($social_icon_shape); ?>" title="<?php echo esc_attr('Pinterest', 'idonate') ?>"> <i class="icofont-pinterest"></i></a>
            <?php
              break;
            case 'email':
            ?>
              <a href="mailto:?Subject=<?php echo esc_attr($Title); ?>&amp;Body=<?php echo esc_url($URL); ?>" title="<?php echo esc_attr('Email', 'idonate') ?>" class="idonate-social-icon icofont-email <?php echo esc_attr($social_icon_shape); ?>"> <i class="icofont-email"></i></a>
            <?php
              break;
            case 'instagram':
            ?>
              <a title="<?php echo esc_attr('Instagram', 'idonate') ?>" onClick="window.open('https://instagram.com/?url=<?php echo esc_url($URL); ?>&amp;text=<?php echo esc_attr($Title); ?>','Twitter share','width=450,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="https://instagram.com/?url=<?php echo esc_url($URL); ?>&amp;text=<?php echo esc_attr($Title); ?>" class="idonate-social-icon idonate-instagram <?php echo esc_attr($social_icon_shape); ?>"> <i class="icofont-instagram" aria-hidden="true"></i></a>
            <?php
              break;
            case 'whatsapp':
            ?>
              <a href="https://api.whatsapp.com/send?text=<?php echo esc_attr($Title); ?>%20<?php echo esc_url($URL); ?>" onClick="window.open('https://api.whatsapp.com/send?text=<?php echo esc_attr($Title); ?>%20<?php echo esc_url($URL); ?>','whatsapp','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_attr('WhatsApp', 'idonate') ?>" class="idonate-social-icon idonate-whatsapp <?php echo esc_attr($social_icon_shape); ?>"> <i class="icofont-whatsapp"></i></a>
            <?php
              break;
            case 'reddit':
            ?>
              <a href="https://reddit.com/submit?url=<?php echo esc_url($URL); ?>&amp;title=<?php echo esc_attr($Title); ?>" onClick="window.open('https://reddit.com/submit?url=<?php echo esc_url($URL); ?>&amp;title=<?php echo esc_attr($Title); ?>','reddit','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_attr('Reddit', 'idonate') ?>" class="idonate-social-icon idonate-reddit <?php echo esc_attr($social_icon_shape); ?>"> <i class="icofont-reddit"></i></a>
            <?php
              break;
            case 'tumblr':
            ?>
              <a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo esc_url($URL); ?>&amp;title=<?php echo esc_attr($Title); ?>" title="<?php echo esc_attr('tumblr', 'idonate') ?>" onClick="window.open('https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo esc_url($URL); ?>&amp;title=<?php echo esc_attr($Title); ?>','tumblr','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" class="idonate-social-icon idonate-tumblr <?php echo esc_attr($social_icon_shape); ?>"><i class="icofont-tumblr"></i></a>
            <?php
              break;
            case 'digg':
            ?>
              <a href="https://digg.com/submit?url=<?php echo esc_url($URL); ?>%&amp;title=<?php echo esc_attr($Title); ?>" onClick="window.open('https://digg.com/submit?url=<?php echo esc_url($URL); ?>%&amp;title=<?php echo esc_attr($Title); ?>','Digg','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_html('digg', 'idonate') ?>" class="idonate-social-icon idonate-digg <?php echo esc_attr($social_icon_shape); ?>"><i class="icofont-digg"></i></a>
            <?php
              break;
            case 'vk':
            ?>
              <a href="https://vk.com/share.php?url=<?php echo esc_url($URL); ?>&amp;title=<?php echo esc_attr($Title); ?>&amp;comment=" title="<?php echo esc_attr('VK', 'idonate') ?>" onClick="window.open('https://vk.com/share.php','VK','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" class="idonate-social-icon idonate-vk <?php echo esc_attr($social_icon_shape); ?>"> <i class="icofont-vk"></i></a>
            <?php
              break;
            case 'xing':
            ?>
              <a href="https://www.xing.com/spi/shares/new?url=<?php echo esc_url($URL); ?>" onClick="window.open('https://www.xing.com/spi/shares/new?url=<?php echo esc_url($URL); ?>','xing','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_attr('Xing', 'idonate') ?>" class="idonate-social-icon idonate-xing <?php echo esc_attr($social_icon_shape); ?>"><i class="icofont-xing"></i></a>
            <?php
              break;
          }
        }
      }
      do_action('idonate_add_last_socials');
      ?>
    </div>
<?php
  }
}
