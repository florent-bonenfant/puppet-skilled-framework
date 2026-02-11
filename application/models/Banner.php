<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banners';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The users that belong to the role.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users', 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeSelectable($query)
    {
        return $query->where([
            ['deleted_at', 'IS NOT NULL'],
        ]);
    }

    public function getFilePath()
    {
        return config_item('data_document_path') . '/banners/' . $this->file_name;
    }

    /**
     * Encode the file prefixed by his mime type
     *
     * @param     BannerModel    $file    [$file description]
     *
     * @return    [string]                  [return description]
     */
    public function getBase64File()
    {
        if (!file_exists($this->getFilePath())) {
            return null;
        }

        $fileContent = file_get_contents($this->getFilePath());
        return $this->mime . ';base64, ' . base64_encode($fileContent);
    }
}
