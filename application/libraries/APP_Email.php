<?php

use Globalis\PuppetSkilled\View\View;

class APP_Email extends CI_Email
{
    protected $email_interception = false;

    protected $to_debug = false;

    protected $cc_debug = false;

    protected $bcc_debug = false;

    protected $email_bcc = false;

    protected $ciphers = 'TLSv1.2';

    /**
     * on force le ssl 1.2     *
     */
    protected $version_ssl = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;

    protected $ssl = [
        'verify_peer' => true,
        'verify_peer_name' => true,
        'allow_self_signed' => false,
        'ciphers' => 'TLSv1.2',
    ];

    /**
     * Set Recipients
     *
     * @param    $to    string
     * @return   CI_Email
     */
    public function to($to)
    {
        if ($this->email_interception) {
            $this->to_debug = $to;
            $to = $this->email_interception;
        }
        return parent::to($to);
    }


    /**
     * Set CC
     *
     * @param    $cc    string
     * @return   CI_Email
     */
    public function cc($cc)
    {
        if ($this->email_interception) {
            $this->cc_debug = $cc;
            $cc = $this->email_interception;
        }
        return parent::cc($cc);
    }

	/**
	 * SMTP Connect
	 *
	 * @return	string
	 */
	protected function _smtp_connect()
	{
		if (is_resource($this->_smtp_connect))
		{
			return TRUE;
		}

		$ssl = ($this->smtp_crypto === 'ssl') ? 'ssl://' : '';

		$this->_smtp_connect = fsockopen($ssl.$this->smtp_host,
							$this->smtp_port,
							$errno,
							$errstr,
							$this->smtp_timeout);

		if ( ! is_resource($this->_smtp_connect))
		{
			$this->_set_error_message('lang:email_smtp_error', $errno.' '.$errstr);
			return FALSE;
		}

		stream_set_timeout($this->_smtp_connect, $this->smtp_timeout);
		$this->_set_error_message($this->_get_smtp_data());

		if ($this->smtp_crypto === 'tls')
		{
			$this->_send_command('hello');
			$this->_send_command('starttls');

			$crypto = stream_socket_enable_crypto($this->_smtp_connect, TRUE, $this->version_ssl);

			if ($crypto !== TRUE)
			{
				$this->_set_error_message('lang:email_smtp_error', $this->_get_smtp_data());
				return FALSE;
			}
		}

		return $this->_send_command('hello');
	}

    /**
     * Set BCC
     *
     * @param    $bcc string
     * @param    $limit string
     * @return   CI_Email
     */
    public function bcc($bcc, $limit = '')
    {
        if ($this->email_interception) {
            $this->bcc_debug = $bcc;
            $bcc = $this->email_interception;
        }
        return parent::bcc($bcc, $limit);
    }


    /**
     * Build Final Body and attachments
     *
     * @return  bool
     */
    protected function _build_message()
    {
        //Debug is active ?
        if ($this->email_interception) {
            $debug_separator = $this->newline;
            if ($this->mailtype === 'html') {
                $debug_separator = "<br/>";
            }

            $this->_body .= $debug_separator . $debug_separator . '**** DEBUG ****' . $debug_separator;

            //Debug
            if ($this->to_debug) {
                $this->_body .= ' to: ' . $this->to_debug . $debug_separator;
            }

            if ($this->cc_debug) {
                $this->_body .= ' cc: ' . $this->cc_debug . $debug_separator;
            }

            if ($this->bcc_debug) {
                $this->_body .= ' bcc: ' . $this->bcc_debug . $debug_separator ;
            }
            $this->_body .= '***************' . $debug_separator;
        } elseif ($this->email_bcc) {
            $this->bcc($this->email_bcc);
        }

        $view = new View();
        $view->set(['content' => $this->_body]);
        $this->_body = $view->render('mail/mail_wrapper');
        return parent::_build_message();
    }
}
