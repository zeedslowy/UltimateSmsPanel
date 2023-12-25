$(document).ready(function () {
    $(".item-add").on("click", function () {

        var sTable = $(".task-items");
        var RowAppend = ['<tr class="item-row">',

            '<td><input type="text" name="unit_from[]" class="form-control description unit_from"></td>' +
            '<td><input type="text" name="unit_to[]" class="form-control description"></td>' +
            '<td><input type="text" name="price[]" class="form-control description"></td>' +
            '<td><input type="text" name="trans_fee[]" class="form-control description"></td>' +
            '</td>' +

            '<td><button class="btn btn-danger bnt-sm" id="RemoveITEM" type="button"><i class="fa fa-trash-o"></i> Delete</button></td>'


            , "</tr>"].join("");
        var sLookup = $(RowAppend);

        var description = sLookup.find(".description");

        $(".item-row:last", sTable).after(sLookup);
        $('.unit_from').focus();

        sLookup.find("#RemoveITEM").on("click", function () {

            $(this).parents(".item-row").remove();

            if ($(".item-row").length < 2) $("#deleteRow").hide();
            var e = $(this).closest("tr");

        });

        return false
    });


});
