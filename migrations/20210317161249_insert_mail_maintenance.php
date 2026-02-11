<?php

class InsertMailMaintenance extends PuppetSkilledMigration
{

    public function up()
    {
        $this->insert('contents', [
            'slug' => 'email_change_password_after_renumbering',
            'type' => 'email',
            'title_key' => 'Fin de maintenance'
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'email_change_password_after_renumbering',
            'local' => 'french',
            'title' => '[Guinot - Mary Cohr] Fin de maintenance',
            'content' => "Chères clientes, chères clients

Nous vous informons que la maintenance du Portail Client est terminée. Le site est à nouveau accessible.
Veuillez trouver ci-dessous votre nouveau code client ainsi que le lien pour initialiser votre nouveau mot de passe.
Code client : {{customer_code}}
Email : {{user_email}}
[Se connecter à l'application]({{front_url}})

Bonne journée,
L'équipe GUINOT-Mary Cohr"
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_change_password_after_renumbering',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'front_url', 'customer_code']),
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug = "email_change_password_after_renumbering"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_change_password_after_renumbering"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_change_password_after_renumbering"');
    }
}
