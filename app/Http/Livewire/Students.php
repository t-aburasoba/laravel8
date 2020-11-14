<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;
use JD\Cloudder\Facades\Cloudder;

class Students extends Component
{
    use WithFileUploads;

    public $ids;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $image;
    public $pastImage;
    public $modalStatus;
    public $modalUpdateStatus;

    public function openModal()
    {
        $this->resetInputFields();
        $this->modalStatus = true;
    }

    public function closeModal()
    {
        $this->modalStatus = false;
    }

    public function openUpdateModal($id)
    {
        $student = Student::where('id', $id)->first();
        $this->ids = $student->id;
        $this->firstname = $student->firstname;
        $this->lastname = $student->lastname;
        $this->email = $student->email;
        $this->phone = $student->phone;
        $this->pastImage = Cloudder::secureShow($student->image, [
            'width'     => 200,
            'height'    => 200
        ]);
        $this->modalUpdateStatus = true;
    }

    public function closeUpdateModal()
    {
        $this->modalUpdateStatus = false;
    }
    
    public function resetInputFields()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->phone = '';
        $this->image = '';
    }

    public function store()
    {
        $validatedData = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'image|max:1024',
        ]);

        if ($this->image) {
            $imagePath = $this->image->getRealPath();
            Cloudder::upload($imagePath, null);
            $publicId = Cloudder::getPublicId();
            $validatedData['image']  = $publicId;
        }

        Student::create($validatedData);
        session()->flash('message', '新規投稿に成功しました。');
        $this->resetInputFields();
        $this->closeModal();
    }

    public function update()
    {
        $validatedData = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'image|max:1024',
        ]);
        if ($this->ids) {
            $student = Student::find($this->ids);
            $publicId = '';
            if ($this->image) {
                if ($student->image) {
                    Cloudder::destroyImage($student->image);
                }
                $imagePath = $this->image->getRealPath();
                Cloudder::upload($imagePath, null);
                $publicId = Cloudder::getPublicId();
            }
            $student->update([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
                'image' => $publicId,
            ]);
            session()->flash('message', '投稿の編集に成功しました。');
            $this->resetInputFields();
            $this->closeUpdateModal();
        }
    }

    public function delete($id)
    {
        if($id)
        {
            Student::where('id', $id)->delete();
            session()->flash('message', '投稿の削除に成功しました。');
        }
    }

    public function render()
    {
        $students = Student::orderBy('id', 'DESC')->get();
        return view('livewire.students.index', compact('students'));
    }
}
