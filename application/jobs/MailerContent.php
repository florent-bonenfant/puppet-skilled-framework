<?php
namespace App\Job;

class MailerContent extends Mailer
{
    protected $contentSlug = null;
    protected $content = null;

    protected $canBeSent = false;

    public function setContent($contentSlug, array $data, $local = null)
    {
        $data = array_map('htmlentities', $data);

        $this->contentSlug = $contentSlug;
        $this->content = app()->contentService->buildContent(
            $this->contentSlug,
            $data,
            $local
        );
        if ($this->content) {
            $this->email->subject($this->content->title)
                ->message($this->content->content);
            $this->canBeSent = true;
        } else {
            $this->canBeSent = false;
        }
    }

    public function handle()
    {
        if ($this->canBeSent) {
            app()->config->load('email', true);
            if (app()->config->item('email_store', 'email')) {
                $dir = app()->config->item('email_store_dir', 'email');
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                $data = [
                    'slug' => $this->contentSlug,
                    'recipients' => $this->email->get_recipients(),
                    'content' => $this->content,
                ];
                $emails = glob($dir . $this->contentSlug . '.*.json');
                $id = str_pad(count($emails)+1, 3, 0, STR_PAD_LEFT);
                file_put_contents(
                    $dir . $this->contentSlug . '.' . $id . '.json',
                    json_encode($data, JSON_PRETTY_PRINT),
                    LOCK_EX
                );
            } else {
                try {
                    if (!$this->email->send()) {
                        log_message('error', 'Erreur lors de l\'envoi de l\'email: ' . $this->email->print_debugger());
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Exception lors de l\'envoi de l\'email: ' . $e->getMessage());
                }
            }
        }
    }
}
