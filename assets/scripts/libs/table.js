// tables setup
export default class Table {
    constructor(id) {
        this.id = id;

        $(() => {
            this.initialize();
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

    initialize() {
        this.initializeSorting();
        this.initializeRowActions();
    }

    initializeSorting() {
        let table = this.getTable();
        let tableModel = this;

        table.find('th .btn-sortable').on("click", function(e) {
            console.log('clicked', $(this));
            e.preventDefault();

            let clickedElement = $(this);
            let column = clickedElement.data('column');
            let direction = clickedElement.data('next-direction');

            table.find('input[name="orderColumn"]').val(column);
            table.find('input[name="orderDirection"]').val(direction);

            tableModel.reload();
        });
    }

    initializeRowActions() {
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
            data: (new FormData(form[0])),
            processData: false,
            contentType: false,
            success: function(response) {
                tableModel.getWrapper().html(response);
                tableModel.initialize();
            },
            error: function(response) {
                alert('Pri načítavnaí došlo k chybe. Skúste to prosím znova.');
            },
            complete: function() {
                // hide loading
                // TODO    
            }
        });
    }
}