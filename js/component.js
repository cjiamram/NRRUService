
arr=window.location.pathname.split('/');
var projectPath=arr[1];
 function getAttachUrlId(url){
      var id=0;
      $.ajax({
         url: url,
         contentType: "application/json; charset=utf-8",
         type: "get",
         dataType: "json",
         async:false,
         success: function(data){
           id=data.id;
           return id;
         } 
     });
     return id;
   }

 function getSystemDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

      if (month.length < 2) 
          month = '0' + month;
      if (day.length < 2) 
          day = '0' + day;
      return [year, month, day].join('-');
  }   



function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getFormatDate(cdate) {
    var mydate = new Date(cdate);
    var dd = String(mydate.getDate()).padStart(2, '0');
    var mm = String(mydate.getMonth() +1).padStart(2, '0'); //January is 0!
    var yyyy = mydate.getFullYear();
    return mm + "/" + dd + "/" + yyyy ;
}

function getDate(cdate) {
    var mydate = new Date(cdate);
    var dd = String(mydate.getDate()).padStart(2, '0');
    var mm = String(mydate.getMonth() +1).padStart(2, '0'); //January is 0!
    var yyyy = mydate.getFullYear();
    return yyyy + "-" + mm + "-" + dd ;
}

function setCurrentDate(obj){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() +1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + '/' + dd + '/' + yyyy;
    $(obj).val(today);
  }

  function setCurrentSysDate(obj){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() +1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $(obj).val(today);
  }

  function getFormatDate(inDate){
    var currentDt = new Date(inDate);;
    var mm = currentDt.getMonth() + 1;
    var dd = currentDt.getDate();
    var yyyy = currentDt.getFullYear();
    var date = mm + '/' + dd + '/' + yyyy;
    return date;
  }

  function addDate(obj,addDay){
    var url=projectPath+"/category/addDay.php?d="+addDay;
    var data=queryData(url);
    var today=getFormatDate(data.AddDay);
    $(obj).val(today);
  }

   function dateDiff(obj,sDate,fDate){
    var url=projectPath+"category/dateDiff.php?sDate="+sDate+"&fDate="+fDate;
    var data=queryData(url);
    var diffDaye=data.DiffDay;
    $(obj).val(diffDaye);
  }

 function setDDL(url,objDDl){
       $.ajax({
            type:'get',
            url:url,
            dataType:'json',
            async:false,
            success:function(data){
                cb="<option value=''>***เลือก***</option>";
                $.each(data, function (index, value) {
                    objCode=Object.keys(value)[1];
                    objName=Object.keys(value)[2];
                    cb+="<option value="+value[objCode]+">"+value[objName]+"</option>";
                });
                $(objDDl).html(cb);
               
            }
        });
  }

   function setDDLPrefix(url,objDDl,prefix){
       $.ajax({
            type:'get',
            url:url,
            dataType:'json',
            async:false,
            success:function(data){
                cb="<option value=''>"+prefix+"</option>";
                $.each(data, function (index, value) {
                    objCode=Object.keys(value)[1];
                    objName=Object.keys(value)[2];
                    cb+="<option value="+value[objCode]+">"+value[objName]+"</option>";
                });
                $(objDDl).html(cb);
               
            }
        });
  }

  function queryData(url){
    var result;
    $.ajax({
	    type:'GET',
	    url:url,
	    dataType:'json',
	    async:false,
	    success:function(data){
        result = data;
	    }
	  });
    return result;
  }

  function getRestURL(){
    data=queryData(projectPath+"buildModel/getConfigURL.php");
    return data.restURL;
  }
 function tablePage(table){
    if ($.fn.dataTable.isDataTable(table)) {
          $(table).dataTable().fnClearTable();
          $(table).dataTable().fnDestroy();
           $(table).DataTable({
                  'paging'      : true,
                  "pageLength": 5,
                  'lengthChange': false,
                  'searching'   : false,
                  'ordering'    : false,
                  'info'        : true,
                  'autoWidth'   : false
          });
    }
    else{
    
    $(table).DataTable({
                  'paging'      : true,
                  "pageLength": 10,
                  'lengthChange': false,
                  'searching'   : false,
                  'ordering'    : false,
                  'info'        : true,
                  'autoWidth'   : false
    });
  }
  }

  function miniPage(table){
    if ($.fn.dataTable.isDataTable(table)) {
          $(table).dataTable().fnClearTable();
          $(table).dataTable().fnDestroy();
           $(table).DataTable({
                  'paging'      : true,
                  "pageLength": 5,
                  'lengthChange': false,
                  'searching'   : false,
                  'ordering'    : false,
                  'info'        : true,
                  'autoWidth'   : false
          });
    }
    else{
    
    $(table).DataTable({
                  'paging'      : true,
                  "pageLength": 5,
                  'lengthChange': false,
                  'searching'   : false,
                  'ordering'    : false,
                  'info'        : true,
                  'autoWidth'   : false
    });
  }
  }

   function setTablePage(table,row){
    if ( $.fn.dataTable.isDataTable( table ) ) {
          $(table).dataTable().fnClearTable();
           $(table).dataTable().fnDestroy();
           $(table).DataTable({
                  'paging'      : true,
                  "pageLength": row,
                  'lengthChange': false,
                  'searching'   : false,
                  'ordering'    : false,
                  'info'        : true,
                  'autoWidth'   : false
          });
    }
    else{
    
    $(table).DataTable({
                  'paging'      : true,
                  "pageLength": row,
                  'lengthChange': false,
                  'searching'   : false,
                  'ordering'    : false,
                  'info'        : true,
                  'autoWidth'   : false
    });
  }
  }


  function logout(){
    $(location).attr('href', 'logout.php')
  }

   function login(){
    $(location).attr('href', 'login.php')
  }




  function executeGet(url){
    var result;
    $.ajax({
      type:'GET',
      url:url,
      dataType:'json',
      async:false,
      success:function(data){
 
       result=data;
      }
    });
    return result;
  }

  

  function executeData(url,jsonObj,isMsg){
  	var jsonData=JSON.stringify (jsonObj);
    var flag=false;
      $.ajax({
  	  	//**************
          url: url,
  	  		contentType: "application/json; charset=utf-8",
	      	type: "POST",
	      	dataType: "json",
	      	data:jsonData,
	      	async:false,
	      	success: function(data){
	      		flag=data.message;
	      	}	
  	  	//**************
  		});
      return flag;
  }

  


