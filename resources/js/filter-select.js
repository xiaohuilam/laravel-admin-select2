window.select2_filter = function (column) {
  jQuery('th.column-' + column + '>.dropdown').not('.select2-filter').remove();
  jQuery("#filter_select2_" + column).select2({
    ajax: {
      url: location.href,
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var query = {
          keyword: params.term,
          page: params.page,
          search: column,
          ['_search_' + column]: true,
        };

        var extra = [];
        if ('undefined' == typeof extra.length) {
          var key;
          for (key in extra) {
            query[key] = eval(extra[key]);
          }
        }

        if (!query.keyword && 1) {
          query.value = $(".dropdown-menu select." + column).attr('data-value');
        }
        return query;
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: $.map(data.data, function (d) {
            d.id = d.id;
            d.text = d.text.replace(new RegExp('\>', 'g'), '&gt;').replace(new RegExp('\<', 'g'), '&lt;');
            return d;
          }),
          pagination: {
            more: data.next_page_url
          }
        };
      },
      cache: true
    },
    allowClear: true,
    placeholder: column,
    minimumInputLength: 0,
    escapeMarkup: function (markup) {
      return markup;
    },

    initSelection: function (element, callback) {
      var value = $("#filter_select2_" + column).val();
      if (!value || !value.trim().length) {
        return callback([]);
      };

      var query = {
        value: value,
        retrive: column,
      };

      var extra = [];
      if ('undefined' == typeof extra.length) {
        var key;
        for (key in extra) {
          query[key] = eval(extra[key]);
        }
      }

      $.ajax({
        url: location.href,
        type: 'GET',
        data: query,
        dataType: 'json',
        success: function (json) {
          var id, text, init = [], option;
          for (id in json) {
            text = json[id] || '';
            init.push({
              id: id,
              text: text,
            });
            option = $('<option/>');
            option.val(id);
            option.attr('selected', 'selected');
            option.text(text.replace(new RegExp('\>', 'g'), '&gt;').replace(new RegExp('\<', 'g'), '&lt;'));
            $("#filter_select2_" + column).append(option);
          }
          callback(init);
        },
      });
    }
  });
}
