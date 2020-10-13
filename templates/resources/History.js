
jQuery.Class("Vtiger_History_Js", {}, {


    getHistory: function (fieldid) {

        var record = $('#recordId').val();
        var thisInstance = this;
        var params = {
            'module': 'Vtiger',
            'action': 'GetFieldHistory',
            'fieldid': fieldid,
            'record': record
        };

        $('#field-history-' + fieldid).popover({
            html: true,
            content: '<div id="popover-history-' + fieldid + '" ></div>',
            trigger: 'focus',
            title: fieldid + '<div style="float:right"><a onclick="$(\'#field-history-' + fieldid + '\').popover(\'hide\')">X</a></div>',
            boundary: 'scrollParent'
        });
        $('#field-history-' + fieldid).popover('show');


        AppConnector.request(params).then(
            function (data) {
                console.log(data);

                $('#popover-history-' + fieldid).html(thisInstance.getHistoryHTML(JSON.parse(data['result'])));
            }
        );
    },


    getHistoryHTML: function (data) {
        var html = '';

        console.log(typeof data);
        var history = data['history'];
        for (var element in history) {
            console.log(history[element]);
            html += '  <strong>' + app.vtranslate('From') + '</strong> ' + history[element]['prevalue'] + ' <strong>' + app.vtranslate('To') + '</strong> ' + history[element]['postvalue'] + '<br> \n' +
                '  <small><strong>' + app.vtranslate('By') + '</strong> ' + history[element]['last_name'] + ' ' + history[element]['changedon'] + '</small>' +
                '  <hr>';
        }
        if (data['created']) {
            html += '  <strong>' + app.vtranslate('Created') + '</strong> ' + data['created']['value'] + '<br> \n' +
                '  <small><strong>' + app.vtranslate('By') + '</strong> ' + data['created']['creator'] + ' ' + data['created']['createdtime'] + '</small>' +
                '  <hr>';
        }
        return html;
    },

    registerPopover: function () {
        $('.field-information').popover();
    },

    getAvalibleFields: function () { 
        var module = $('#module').val();
        
        postData = {
            "module": "History", 
            "action": "Fields", 
            "mode": "getAvalibleFields", 
            "currentModule": module 
        }; 
    }, 

    init : function () { 
        var module = $('#module').val();
        var view = $('#view').val(); 

        if (view !== 'Detail') {
            return false; 
        }

        var fields = this.getAvalibleFields();
         
    }, 

    registerEvents: function () {
        this.init();
        this.registerPopover();
         
    },
});

