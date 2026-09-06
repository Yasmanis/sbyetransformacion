<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Module;
use App\Repositories\FileRepository;
use App\Traits\FileSave;
use Illuminate\Http\Request;

class PlatformController extends LifeController
{

    use FileSave;

    public function addFileToPublication(Request $request)
    {
        $repository = new FileRepository();
        $data = $request->only((new ($repository->model()))->getFillable());
        $data['public_access'] = true;
        $data['public_date'] = now();

        if ($request->hasFile('file')) {
            $properties = $this->getPropertiesFromFile($request->file('file'), 'files', 'public');
            if (!isset($request->name)) {
                $data['name'] = $properties['originalName'];
            }
            $data['path'] = $properties['path'];
            $data['type'] = $properties['type'];
            $data['size'] = $properties['size'];
        } else {
            $data['type'] = 'link';
        }
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('files/poster', 'public');
            $data['poster'] = $path;
        }
        $data['principal'] = $request->input('principal', 1) === 1 || $request->input('principal', '1') === '1';
        $obj = $repository->create($data);
        return $obj;
    }

    public function getSections()
    {
        $m = Module::firstWhere('model', $this->segment());
        return $m->sections;
    }

    public function getCategory()
    {
        return Category::firstWhere('name', $this->segment());
    }
}
