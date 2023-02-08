<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Barangay;
use Livewire\WithPagination;

class BarangaysComponent extends Component
{
    public $searchTerm;
    // public $records = [];
    public $perPage = 5;

    public $barangay_name;
    public $barangay_head;
    public $contact_number;

    public $deleteConfirmed;
    public $updateMode = false;
    public $edit_id;
    protected $listeners = ['remove'];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        return view('livewire.admin.barangays-component',[
            'records' => $this->records
        ]);
    }

    public function getRecordsProperty()
    {
        return Barangay::search(trim($this->searchTerm))
            ->paginate($this->perPage);
    }

    public function add()
    {
        $this->dispatchBrowserEvent('show-form-modal');
        $this->resetInputFields();

    }

    public function submit()
    {
        $this->validate([
            'barangay_name' => 'required',
            'barangay_head' => 'required',
            'contact_number' => 'required'
        ]);

        $data = Barangay::create([
            'barangay_name' => $this->barangay_name,
            'barangay_head' => $this->barangay_head,
            'contact_number' => $this->contact_number
        ]);
        if($data) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Barangay Data Successfully Added!',
                'text' => '.',
                'button' => false,
            ]);

            $this->dispatchBrowserEvent('hide-form-modal');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => '.',
                'button' => false,
            ]);
        }

    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-form-modal');
        $this->updateMode = true;
        $this->edit_id = $id;
        $data = Barangay::find($id);
        $this->barangay_name = $data->barangay_name;
        $this->barangay_head = $data->barangay_head;
        $this->contact_number = $data->contact_number;
    }

    public function updatingSearchTerm()
    {
        // sleep(.2);
        $this->resetPage();
    }

    public function update()
    {
        $this->validate([
            'barangay_name' => 'required',
            'barangay_head' => 'required',
            'contact_number' => 'required'
        ]);

        $data = Barangay::findOrFail($this->edit_id);
        $data->update([
            'barangay_name' => $this->barangay_name,
            'barangay_head' => $this->barangay_head,
            'contact_number' => $this->contact_number
        ]);

        if($data){
            $this->dispatchBrowserEvent('swal:modal', [
                'positiom' => 'top-end',
                'type' => 'success',
                'message' => 'Barangay Data Successfully Updated!',
                'text' => '.',
                'button' => false,
                'timer' => 1500
            ]);

            $this->dispatchBrowserEvent('hide-form-modal');

            $this->resetInputFields();

            $this->updateMode = false;
        }
    }

    public function alertConfirm($id)
    {
        $this->deleteConfirmed = $id;
        $this->dispatchBrowserEvent('swal:confirm', [
            'positiom' => 'top-end',
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'If deleted, you will not be able to recover this imaginary file!'
        ]);
    }

    public function remove()
    {
        $delete = Barangay::find($this->deleteConfirmed)->delete();
        if($delete){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Barangay has been removed!',
                'text' => '.',
                'button' => false,
                'timer' => 1500
            ]);
        }
    }

    public function resetInputFields()
    {
        $this->barangay_name = "";
        $this->barangay_head = "";
        $this->contact_number = "";
    }
}
