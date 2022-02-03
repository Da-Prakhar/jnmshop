$(function () {
      "use strict";
      var table = $('#compainsTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          language: {
            searchPlaceholder: "Search Brands..."
          },
          columns: [
              {data: 'DT_RowIndex', name: 'complaints.compain_id', searchable : false},
              {data : 'complain_ref_no', name : 'complaints.complain_ref_no'},
              {data : 'complain_by_user_id', name : 'complaints.complain_by_user_id'},
              {data : 'complain_by_name', name : 'complaints.complain_by_name'},
              {data : 'mobile', name : 'complaints.mobile'},
              {data : 'title', name : 'complaints.title'},
              {data : 'issue_date', name : 'complaints.issue_date'},
              {data : 'resolved_date', name : 'complaints.resolved_date'},
              {data : 'category', name : 'complaints.category'},
              {data : 'sub_category', name : 'complaints.sub_category'},
              {data : 'sub_category', name : 'complaints.sub_category'},
              {data : 'photo', name : 'complaints.photo',searchable : false, orderable : false},              
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });
      
});