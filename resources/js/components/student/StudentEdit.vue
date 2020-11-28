<template>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="id_number">ID Number</label>
                    <input type="number" name="id_number" class="form-control" id="id_number1" value=""
                        placeholder="Enter ID Number">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name1" class="form-control" id="first_name"
                        value=""
                        placeholder="Enter First Name">
                </div>

            <div class="form-group col-md-4">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" id="middle_name1"
                    value=""
                    placeholder="Enter Middle Name">
            </div>

            <div class="form-group col-md-4">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name1"
                    value=""
                    placeholder="Enter Last Name">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email1"
                    value=""
                    placeholder="Enter Email">
            </div>

            <div class="form-group col-md-6">
                <label for="contact_number">Contact Number</label>
                <input type="number" name="contact_number" class="form-control" id="contact_number1"
                    value=""
                    placeholder="Enter Contact Number">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Select Clusters</label>
                <div class="border px-2 py-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="cluster"
                                    name=""
                                    value=""
                                >
                                <label class="custom-control-label" for=""></label>
                            </div>
                        <p class="text-warning">No Course Available</p>
                </div>
        </div>
            <input type="hidden" name="" value="">
        </div>
        </div> 
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    </div>
</template>
