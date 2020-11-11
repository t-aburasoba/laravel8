<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class Students extends Component
{
    public $ids;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
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
    }

    public function store()
    {
        $validatedData = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

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
        ]);
        if ($this->ids) {
            $student = Student::find($this->ids);
            $student->update([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
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
