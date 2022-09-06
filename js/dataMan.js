<script type="text/java script">

		function sendPost(data,url,areaDiv)
		{
			 $.ajax({
				           type: "POST",
				           url: url,
				           data: data, // serializes the form's elements.
				           success: function(data)
				           {
				               $("#"+dreaDiv).html(data);
				           }
				         }
				    );
		}

		/*

 var data ={};
				    for(i=0;i<objs.length;i++)
					{	
						data[objs[i]] = document.getElementById(objs[i]).value;
					}
		*/

		function sendGet(url,areaDiv)
		{
			 $.ajax(
			 {
               type: "get",
               url: url,
               success: function (data) 
               {
                   $("#"+areaDiv).html(data);
               }
             }
           );
		}

		function getChildDLL(url,childName)
		{
			 $.ajax(
			 {
               type: "get",
               url: url,
               success: function (data) 
               {
                    $('select[name=childName]').html(data.response);
               }
             }
           );
		}

</script>