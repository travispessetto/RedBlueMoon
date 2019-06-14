$(document).ready(function()
{
    $('button').click(startProcess);
});

var startProcess = function(event)
{
    event.preventDefault();
    $('#overlay').show();
    checkFolderIsWritable();
}

var checkFolderIsWritable = function()
{
    $.get('controller.php','action=checkFolder',
    function(data,status,xhr)
    {
        if(data.writable)
        {
            $('#folder-writability').html('<i class="fa fa-check green"></i>');
            $('#folder-writability').removeClass('todo');
            importDatabase();
        }
        else
        {
            $('.todo').html('<i class="fa fa-times red"></i>');
        }
    }).fail(
        function()
        {
            alert("A fatal error occured");
        }
    );
}

var importDatabase = function()
{
    var database = $('input[name="database"]').val();
    var databaseServer = encodeURIComponent($('input[name="database_server"]').val());
    var databaseUser = encodeURIComponent($('input[name="database_user"]').val());
    var databasePassword = encodeURIComponent($('input[name="database_password"]').val());
    var oldUrl = encodeURIComponent($('input[name="old_url"]').val());
    var newUrl = encodeURIComponent($('input[name="new_url"]').val());

    $.post('controller.php?action=importDatabase',"database="+database+"&databaseUser="+databaseUser+"&databasePassword="+databasePassword+
    '&databaseServer='+databaseServer+'&oldUrl='+oldUrl+'&newUrl='+newUrl,
    function(data,status,xhr)
    {
        if(data.imported)
        {
            $('#database-import').html('<i class="fa fa-check green"></i>');
            $('#database-import').removeClass('todo');
            extract();
        }
        else
        {
            $('.todo').html('<i class="fa fa-times red"></i>');
            alert(data.message);
        }
    }).fail(
        function()
        {
            alert("A fatal error occured");
        }
    );
}

var extract = function()
{
    var database = $('input[name="database"]').val();
    var databaseServer = encodeURIComponent($('input[name="database_server"]').val());
    var databaseUser = encodeURIComponent($('input[name="database_user"]').val());
    var databasePassword = encodeURIComponent($('input[name="database_password"]').val());
    $.post('controller.php?action=extract',"database="+database+"&databaseUser="+databaseUser+"&databasePassword="+databasePassword+
    '&databaseServer='+databaseServer,
    function(data,status,xhr)
    {
        if(data.extracted)
        {
            $('#files-extracted').html('<i class="fa fa-check green"></i>');
            $('#files-extracted').removeClass('todo');
        }
        else
        {
            $('.todo').html('<i class="fa fa-times red"></i>');
        }
    }).fail(
        function()
        {
            alert("A fatal error occured");
        }
    );
}