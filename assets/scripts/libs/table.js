// tables setup
export default class Table {
    constructor(id) {
        this.id = id;

        $(() => {
            this.initializeActions();
        });
    }
    getWrapper() {
        return $(`#${this.id}-wrapper`);
    }
    getTable() {
        return $(`#${this.id}`);
    }
    getRowPk(clickedElement) {
        return clickedElement.parents('tr').data('pk');
    }

    initializeActions() {
        let table = this.getTable();
        let tableModel = this;

        table.find('.btn-delete').on("click", function(e) {
            tableModel.delete(tableModel.getRowPk($(this)));
            e.preventDefault();
        });

        table.find('.btn-edit').on("click", function(e) {
            tableModel.edit(tableModel.getRowPk($(this)));
            e.preventDefault();
        });
    }

    delete(pk) {
        if (!confirm('Naozaj chcete zmazať tento záznam?')) {
            return;
        }

        var tableWrapper = this.getWrapper();
        var tableModel = this;

        // show loading
        // TODO

        $.ajax({
            url: tableWrapper.data('delete-url'),
            method: 'POST',
            data: {
                pk: pk
            },
            success: function(response) {
                if (response.success) {
                    tableModel.deletePostSuccess(response);
                } else {
                    alert('Pri mazaní došlo k chybe. Skúste to prosím znova.');
                }
            },
            error: function(response) {
                alert('Pri mazaní došlo k chybe. Skúste to prosím znova.');
            },
            complete: function() {
                // hide loading
                // TODO    
            }
        });
    }
    deletePostSuccess(response) {
        if (!response.success) {
            alert(response.title);
            return;
        }

        window.location.reload();
    }

    edit(pk) {
        window.location.href = this.getWrapper().data('form-url') + '/' + pk;
    }

    reload() {
        const tableModel = this;
        const tableWrapper = this.getWrapper();
        const form = tableWrapper.find('form');

        // show loading
        // TODO
        
        $.ajax({
            url: tableWrapper.data('table-url'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                tableModel.getWrapper().html(response);
                tableModel.initializeActions();
            },
            error: function(response) {
                alert('Pri ukladaní došlo k chybe. Skúste to prosím znova.');
            },
            complete: function() {
                // hide loading
                // TODO    
            }
        });
    }
}