<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\v1\event;
use App\Models\v1\launche;

class article extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $guarded = ['id'];


    /**Regras de Validação de Insert */
    public function rules()
    {
        return [
            'featured'=> "required|boolean",
            'title' => "required|max:190",
            'url' => "required|max:190",
            'imageUrl' => "required|max:190",
            'newsSite' => "required|max:190",
            'summary' => "required|max:190",
            'publishedAt' => "required|date_format:Y-m-d H:i:s",
            'updatedAt' => "required|date_format:Y-m-d H:i:s",
            'events_id' => "required|integer|exists:events,id",
            'launches_id' => "required|integer|exists:launches,id"
        ];
    }

    /**Regras de Validação de Insert - Feedback */
    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'integer' => 'Precisa ser um número inteiro',
            'date_format' => 'Formato da data está incorreto',
            'events_id.exists' => 'Não existe events com este ID',
            'launches_id.exists' => 'Não existe launches com este ID'
        ];
    }

    /**
     * Relacionamento com a tabela Events
     *
     * @return void
     */
    public function events()
    {
        return $this->hasMany(event::class, 'id', 'events_id');
    }

    /**
     * Relacionamento com a tabela Launches
     *
     * @return void
     */
    public function launches()
    {
        return $this->hasMany(launche::class, 'id', 'launches_id');
    }

    /**
     * Pesquisar Registros
     *
     * @param  mixed $search
     * @return void
     */
    public function getDados($search = null, $orderByKey, $orderByVal, $per_page)
    {

        $registros =  $this
            ->select(
                'articles.id',
                'articles.featured',
                'articles.title',
                'articles.url',
                'articles.imageUrl',
                'articles.newsSite',
                'articles.summary',
                'articles.publishedAt',
                'articles.summary',
                'articles.events_id',
                'articles.launches_id',
            )
            ->where('articles.title', 'LIKE', "%{$search}%")
            ->with('events', 'launches')
            ->orderBy($orderByKey, $orderByVal)
            ->paginate($per_page);

        return $registros;
    }
}
