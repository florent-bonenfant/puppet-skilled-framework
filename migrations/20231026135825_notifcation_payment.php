<?php

class NotifcationPayment extends PuppetSkilledMigration
{
    public function up()
    {
        $this->insert('contents', [
            'slug'      => 'email_payment_success',
            'type'      => 'email',
            'title_key' => 'Email Confirmation de paiement',
            'active'    => 1
        ]);
        $this->insert('contents_translations', [
            'content_slug' => 'email_payment_success',
            'local'        => 'french',
            'title'        => '[Guinot - Mary Cohr] Confirmation de paiement',
            'content'      => "Bonjour, \r\n\r\nNous vous confirmons le paiement effectué sur le Portail Client, d'un montant de {{amount}}€ EUR, pour le motif {{reason}} le {{date}}.\r\n\r\n[Accéder à l'extranet Guinot]({{front_url}})",
        ]);
        $this->insert('contents_metas', [
            'content_slug' => 'email_payment_success',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'amount', 'date', 'reason', 'front_url']),
        ]);

        $this->insert('contents', [
            'slug'      => 'email_payment_failed',
            'type'      => 'email',
            'title_key' => 'Email Refus de paiement',
            'active'    => 1
        ]);
        $this->insert('contents_translations', [
            'content_slug' => 'email_payment_failed',
            'local'        => 'french',
            'title'        => '[Guinot - Mary Cohr] Refus de paiement',
            'content'      => "Bonjour, \r\n\r\nNous vous informons que la tentative de paiement sur le Portail Client, d'un montant de {{amount}}€ EUR, pour le motif {{reason}} le {{date}}, n'a pas abouti.\r\n\r\nEn raison de : {{payment_status}}\r\n\r\n[Accéder à l'extranet Guinot]({{front_url}})",
        ]);
        $this->insert('contents_metas', [
            'content_slug' => 'email_payment_failed',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'payment_status', 'amount', 'date', 'reason', 'front_url']),
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug = "email_payment_success"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_payment_success"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_payment_success"');

        $this->execute('DELETE FROM contents WHERE slug = "email_payment_failed"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_payment_failed"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_payment_failed"');
    }
}
