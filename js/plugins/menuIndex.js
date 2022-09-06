


 function getMenu(){
  var url="/ERP/menu/listMenu.php";
  var data=queryData(url);
  var row="";

   var i=0;
   var j=1;
   $.each(data, function (index, value) {
        if(value.LevelNo!=0)
         { 
            var topic=i+"."+j;
            row+= "<li><a href='"+value.Link+"'><i class='fa fa-link'></i><span>"+"&nbsp;&nbsp;"+topic+" "+value.MenuName+"</span></a></li>\n";
            j++;
         }
        else{
              row+="<li class=\"header\">"+(++i)+" "+value.MenuName+"</li>\n";
              j=1;
            }
    });

   $('#ulMenu').html(row);

}