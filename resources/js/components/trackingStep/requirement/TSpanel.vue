<template>
<div>
    <div class=" px-4 py-4 mb-1">
    <h4></h4>
    <div class="d-flex">
            <a href="" class="btn btn-dark btn-sm mr-2">Assign New Panel</a>
                    <span onclick="" class="btn btn-danger btn-sm">
                    Delete
                </span>
                    <form style="display: none" id="form-delete-panelRequirement" action="}" method="POST">
                    </form>
    </div>
</div>

    <div class=" px-4 py-4 mb-1 ">
        <div class="d-flex justify-content-between border-bottom">
            <h4></h4>
                <div class="d-flex">
                        <div>
                            <span class="mb-2">
                                <a href="" class="btn btn-dark btn-sm">Edit</a>
                            </span>
                            <span onclick="" class="btn btn-danger btn-sm">
                                    Remove Panel
                                </span>
                            <form style="display: none" id="form-remove-panel" action="" method="POST">
                            </form>
                        </div>
                        <div>
                            <span onclick="" class="btn btn-dark btn-sm">
                                Restore Panel
                            </span>
                            <form style="display: none" id="form-restore-panel" action="" method="POST">
                            </form>
                        </div>
                </div>
        </div>

        <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>Panel:</td>
                <td>
                    <a href="" target="_blank"><strong></strong></a>
                </td>
            </tr>
            <tr>
                <td>Type:</td>
                <td><strong></strong></td>
            </tr>
                <tr>
                    <td>Forms:</td>
                </tr>
                    <tr>
                        <td></td>
                        <td><a href="" target="_blank"></a></td>
                        <td>
                                <span onclick="" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-panelForm" action="" method="POST">
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