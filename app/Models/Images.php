<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [

        'image',
        'description'


    ];

    public function updateMultiple(array $values)
    {
        $table = MyModel::getModel()->getTable();;
        $ids = [];
        $params = [];
        $columnsGroups = [];
        $queryStart = "UPDATE {$table} SET";
        $columnsNames = array_keys(array_values($values)[0]);
        foreach ($columnsNames as $columnName) {
            $cases = [];
            $columnGroup = " ".$columnName ." = CASE id ";
            foreach ($values as $id => $newData){
                $cases[] = "WHEN {$id} then ?";
                $params[] = $newData[$columnName];
                $ids[$id] = "0";
            }
            $cases = implode(' ', $cases);
            $columnsGroups[] = $columnGroup. "{$cases} END";
        }
        $ids = implode(',', array_keys($ids));
        $columnsGroups = implode(',', $columnsGroups);
        $params[] = Carbon::now();
        $queryEnd = ", updated_at = ? WHERE id in ({$ids})";
        return DB::update($queryStart.$columnsGroups. $queryEnd, $params);
    }

//    updateMultiple([12 => ['name'=> 'a', 'age' => 10], 33 => ['name'=> 'b', 'age' => 12]]);
// updateMultiple([id => [columnNam => $newValue, columnNam => $newValue]], ...)

    public function post()
    {
        return $this->belongsTo(Posts::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
