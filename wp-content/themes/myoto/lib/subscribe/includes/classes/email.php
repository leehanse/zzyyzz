<?php
/**
 *
 * All rights reserved. For license information, contact Synotac Design at
 * http://www.synotac.com
 *
 * @package Core
 * @subpackage Email
 * @copyright Copyright 2007 by Synotac Design LLC
 * @version $Id: email.php 1 2008-02-08 23:04:44Z bill $
 *
 */

  /** do not allow direct access */
  defined('_VALID_INCLUDE') || trigger_error('direct call not allowed', E_USER_ERROR);

  require_once(PEAR . '/Mail.php');
  require_once(PEAR . '/Mail/mime.php');
  require_once(PEAR . '/Mail/mimePart.php');  //called in PEAR/MAIL/mime.php

  /**
   * Wrapper class for PEAR email classes.
   *
   * This class attempts to take the headaches out of using the PEAR classes
   * by making, hopefully, easier to use methods. In order to send an email,
   * you must set the email body as either HTML or text or both, provide an
   * array of recipients, and an array of mail headers.
   *
   * NOTE - this only works with the 'mail' factory and has not been tested
   * with the SMTP factory. There are notes from a previous version of this
   * which indicate some problems with the SMTP factory so beware.
   *
   * The only required items to send an email are a recipient and either
   * an HTML or text message body.
   *
   * Any RFC822 compliant email address should work for any function that takes
   * an address but this has not been fully tested.
   *
   * @package Core
   * @subpackage Email
   */
  class Email {

    /**
     * @var string HTML version of email
     * @access private
     */
    var $_Html = '';

    /**
     * @var string Text version of email
     * @access private
     */
    var $_Text = '';

    /**
     * @var array of address to receive the email ("To:")
     * @access private
     */
    var $_Recipient = array();

    /**
     * @var array of addresses to get copies ("Cc:")
     * @access private
     */
    var $_Copy = array();

    /**
     * @var array of addresses to get blind copies ("Bcc:")
     * @access private
     */
    var $_BlindCopy = array();

    /**
     * @var array of mail headers
     * @access private
     */
    var $_Headers = array();

    /**
     * Create object
     */
    function Email() {
    }

    /**
     * Set one recipient for email
     *
     * @param string RFC822-compliant email address for recipient or series of addresses
     *               separated by commas
     */
    function SetRecipient($address) {
      $this->_Recipient[] = $address;
    }   // end SetRecipient

    /**
     * Set one copy ("Cc:") for email
     *
     * @param string RFC822-compliant email address for Cc or series of addresses separated by
     *               commas
     */
    function SetCopy($address) {
      $this->_Copy[] = $address;
    }   // end SetCopy()

    /**
     * Set one blind copy ("Bcc:") for email
     *
     * @param string RFC822-compliant email address for Bcc or series of addresses separated by
     *               commas
     */
    function SetBlindCopy($address) {
      $this->_BlindCopy[] = $address;
    }   // end SetBlindCopy()

    /**
     * Convenience function to set message subject.
     *
     * @param string message subject
     */
    function SetSubject($subject) {
      $this->_Headers['Subject'] = $subject;
    }   // end SetSubject()

    /**
     * Convenience function to set mailer name
     *
     * @param string mailer name
     */
    function SetMailer($string) {
      $this->_Headers['X-Mailer'] = $string;
    }   // end SetMailer()

    /**
     * Convenience function to set "From" email address. This is also used to
     * set "Return-path"
     *
     * @param string RFC822-compliant email address for "From" header
     */
    function SetFrom($string) {
      $this->_Headers['From'] = $string;
    }   // end SetFrom()

    /**
     * Set arbitrary header.
     *
     * The header name and value are used to construct the actual mail header.
     * For example, if the call is
     * <pre>
     * $mail_object->SetHeader('Reply-to', 'test@testers.com');
     * </pre>
     * then the header is 'Reply-to: test@testers.com'
     *
     * @param string $hdr_name Header name
     * @param string $hdr_value Header value
     */
    function SetHeader($hdr_name, $hdr_value) {
      $this->_Headers[$hdr_name] = $hdr_value;
    }   // end SetHeader()

    /**
     * Set the message body as HTML
     *
     * @string $html HTML for message body
     */
    function SetHtml($html) {
      $this->_Html = $html;
    }   // end SetHtml()

    /**
     * Set the message body as Text
     *
     * @string text for message body
     */
    function SetText($text) {
      $this->_Text = $text;
    }   // end SetText()

    /**
     * Send email
     *
     */
    function SendMail() {
      PEAR::setErrorHandling(PEAR_ERROR_RETURN);


      if (empty($this->_Recipient)) {
        trigger_error('email::send_mail: no recipients: ' . print_r($this->_Recipient, true), E_USER_WARNING);
        return false;
      }

      if (!empty($this->_Headers['To'])) {
        $this->_Recipients[] = $this->_Headers['To'];
        unset($this->_Headers['To']);
      }

      $recipients = implode(', ', $this->_Recipient);
      if ($this->_Copy) {
        $this->_Headers['Cc'] = implode(', ', $this->_Copy);
      }

      if ($this->_BlindCopy) {
        $this->_Headers['Bcc'] = implode(', ', $this->_BlindCopy);
      }

      if (!empty($this->_Headers['From'])) {
        require_once('PEAR/Mail/RFC822.php');
        $parser = new Mail_RFC822();
        $address = $parser->parseAddressList($this->_Headers['From']);
        $from = $address[0]->mailbox . '@' . $address[0]->host;
        $params = '-f' . $from;
      } else {
        $params = null;
      }

      $mail =& Mail::factory('mail', $params);

      if (PEAR::isError($mail)) {
        error_log('PEAR error getting mail object ' . print_r($mail, true));
        trigger_error('PEAR error getting mail object', E_USER_WARNING);
        return false;
      }

      $mime = new Mail_mime();

      if (!empty($this->_Html)) {

      // find any images and embed them in the mail
        $html_fns = array();
        $html_images = array();
        preg_match_all('|<img .*src="(.+)".*>|Ui', $this->_Html, $image_matches);
        $html_fns = array_unique($image_matches[1]);
        foreach ($html_fns as $filename) {
          $return = $mime->addHTMLImage(DOC_ROOT . $filename, $c_type='image/' . $this->_GetExtension($filename), '');
          if (PEAR::isError($return)) {
            echo $return->getMessage();
            exit('PEAR error');
          }
          $this->_Html= str_replace($filename, basename($filename), $this->_Html);
        }

        $mime->setHTMLBody($this->_Html);
      }

      /**
       * @todo handle when *both* text and html are empty
       */
      if (empty($this->_Text)) {
        $this->_Text = $this->_Html2Text($this->_Html);
      }
      $mime->setTXTBody($this->_Text);
      $body = $mime->get();
      $headers = $mime->headers($this->_Headers);

      // echo '<pre>' . print_r($recipients, true);
      // echo '<pre>' . print_r($headers, true);
      // echo '<pre>' . print_r($body, true);
      // echo __FILE__ . ' line: ' . __LINE__ . '</pre><br />';
      // exit;

      return $mail->send($recipients, $headers, $body);

    }   // end SendMail()

    /**
     * Simple html-to-text converter
     *
     * @param string $html Html to convert to text
     * @return string result of conversion
     */
    function _Html2Text($html) {
      $strip_tags_search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                       "'<style[^>]*?>.*?</style>'si",    //Strip out style tags
                       "'<head[^>]*?>.*?</head>'si",      //Strip out head tags
                       "'<br>'",
                       "'</p>'",
                       "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                       "'([\r\n])[\s]+'",                 // Strip out white space
                       "'&(quot|#34);'i",                 // Replace html entities
                       "'&(amp|#38);'i",
                       "'&(lt|#60);'i",
                       "'&(gt|#62);'i",
                       "'&(nbsp|#160);'i",
                       "'&(iexcl|#161);'i",
                       "'&(cent|#162);'i",
                       "'&(pound|#163);'i",
                       "'&(copy|#169);'i",
                       "'&#(\d+);'e");                    // evaluate as php

      $strip_tags_replace = array ("",                    // no javascript
                        "",                               // no style tags
                        "",                               // no head tags
                        "\n",
                        "</p>\n",
                        "",                               // no html tags
                        "\\1",                            // no white space
                        "\"",                             // replaced html entities
                        "&",
                        "<",
                        ">",
                        " ",
                        chr(161),
                        chr(162),
                        chr(163),
                        chr(169),
                        "chr(\\1)");

      $text = preg_replace("'&#0(\d+);'", "&#\\1;", $html);  // strip leading zeros so PHP does not think it octal
      $text = preg_replace ($strip_tags_search, $strip_tags_replace, $text);
      return str_replace("\n", "\n\n", $text);
    }   // end _Html2Test()

    /**
     * Get file extension from file name
     *
     * @param string $filename file or full path name
     * @return string file extension
     */
    function _GetExtension($filename) {
      return (count($tmp = explode('.', basename($filename))) > 1) ? strtolower(array_pop($tmp)) : '';
    }   // end _GetExtension()

  }   // end class Email

?>