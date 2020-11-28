<template>
<div>
    <div class=" px-4 py-4 mb-1">
        <h4></h4>
        <div class="d-flex">
                <a href="" class="btn btn-dark btn-sm mr-2">Upload New File</a>
                        <span onclick="" class="btn btn-danger btn-sm">
                            Delete
                        </span>
                        <form style="display: none" id="form-delete-fileRequirement" action="" method="POST">
                        </form>
        </div>
    </div>
    <div class=" px-4 py-4 mb-1">
        <div class="d-flex justify-content-between border-bottom">
            <h4></h4>
                <div class="d-flex">
                        <div>
                            <span>
                                <a href="" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                            <span onclick="" class="btn btn-danger btn-sm">
                                Remove File
                            </span>
                            <form style="display: none" id="" action="" method="POST">
                            </form>
                        </div>
                        <div>
                            <span onclick="" class="btn btn-dark btn-sm">
                                Restore File
                            </span>
                            <form style="display: none" id="form-restore-file" action="" method="POST">
                            </form>
                        </div>
                </div>
        </div>

        <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>File:</td>
                <td>
                    <a href="" target="_blank"><strong></strong></a>
                </td>
            </tr>
                <tr>
                    <td>Forms:</td>
                </tr>
                    <tr>
                        <td>}</td>
                        <td><a href="" target="_blank"></a></td>
                        <td>
                                <span onclick="" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-fileForm" action="" method="POST">
                                </form>
                        </td>
                    </tr>

            <tr>
                <td>Date Created:</td>
                <td></td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td></td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</template>