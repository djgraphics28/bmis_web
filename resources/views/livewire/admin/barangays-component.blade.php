<div>
    <div class="row">
        <div class="col-md-4">
            <input wire:model="searchTerm" type="text" class="form-control bg-primary-700" placeholder="Search Here ..." >
        </div>
        <div class="col-md-7"> <div class="d-flex justify-content-center">
            <div wire:loading class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div></div>
        <div class="col-md-1">
            <button wire:click="add" class="btn btn-primary form-control ">ADD</button>
        </div>

    </div>


    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-2">

                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th class="text-start" style="width: 20%">Barangay</th>
                                <th class="text-start" style="width: 20%">Punong Barangay</th>
                                <th class="text-center" style="width: 15%">Contact</th>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $data)
                                <tr>
                                    <td class="text-center">{{ $data->id }}</td>
                                    <td class="text-start">{{ $data->barangay_name }}</td>
                                    <td class="text-start">{{ $data->barangay_head }}</td>
                                    <td class="text-center">{{ $data->contact_number }}</td>
                                    <td class="text-center">
                                        <button wire:click="edit({{ $data->id }})" class="btn btn-warning">EDIT</button>
                                        <button wire:click="alertConfirm({{ $data->id }})" class="btn btn-danger">REMOVE</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="5">
                                        <center>
                                            No Data Found
                                        </center>
                                    </th>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>


                </div>
                <div class="car-footer p-3">
                    {{ $records->links() }}
                </div>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Barangay</label>
                            <input wire:model="barangay_name" type="text"
                                class="form-control @error('barangay_name') is-invalid @enderror">
                            @error('barangay_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Punong Barangay</label>
                            <input wire:model="barangay_head" type="text"
                                class="form-control @error('barangay_head') is-invalid @enderror">
                            @error('barangay_head')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Contact</label>
                            <input wire:model="contact_number" type="text"
                                class="form-control @error('contact_number') is-invalid @enderror">
                            @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        @if ($updateMode)
                            <button wire:click="update" type="button" class="btn btn-success">Update changes</button>
                        @else
                            <button wire:click="submit" type="button" class="btn btn-primary">Save changes</button>
                        @endif


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
     window.addEventListener('show-form-modal', event => {
        $('#formModal').modal('show');
    })
    window.addEventListener('hide-form-modal', event => {
        $('#formModal').modal('hide');
    })
    window.addEventListener('swal:modal', event => {
        swal({
            position: event.detail.position,
            title: event.detail.message,
            text: event.detail.text,
            icon: event.detail.type,
            button: event.detail.button,
            timer: event.detail.timer,
        });
    });
    window.addEventListener('swal:confirm', event => {
        swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.livewire.emit('remove');
                }
        });
    });
</script>
@endpush
