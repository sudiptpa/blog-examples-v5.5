<?php

namespace App\Mail;

use App\Browser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sujip\GeoIp\GeoIp;

/**
 * Class AuthorizeDevice
 * @package App\Mail
 */
class AuthorizeDevice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $authorize;

    /**
     * Create a new message instance.
     *
     * @param $authorize
     *  @return void
     */
    public function __construct($authorize)
    {
        $this->authorize = $authorize;
        $this->browser = new Browser;
    }

    /**
     * @return mixed
     */
    public function setBrowser()
    {
        $this->authorize->browser = $this->browser->getBrowser();

        return $this;
    }

    /**
     * @return mixed
     */
    public function setToken()
    {
        $this->authorize->token = guid();

        return $this;
    }

    /**
     * @return mixed
     */
    public function setLocation()
    {
        $location = with(new GeoIp(
            $this->authorize->ip_address
        ))->formatted();

        $this->authorize->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function setPlatform()
    {
        $this->authorize->os = $this->browser->getPlatform();

        return $this;
    }

    public function saveAuthorize()
    {
        $this->authorize->save();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->setBrowser()
            ->setToken()
            ->setLocation()
            ->setPlatform()
            ->saveAuthorize();

        return $this
            ->view('emails.auth.authorize')
            ->with(['authorize' => $this->authorize]);
    }
}
