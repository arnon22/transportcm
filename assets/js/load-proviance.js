$(function(){
    $('#province1').change(function(){
       $('#PostID').text("");
       var ID = "";
       
       //ID = $(this).val();
       
       //var data_qampur = "ID="+ID+"&TYPE=Amphur";
        
        $.ajax({
			  url: "customers/getamphur",//�������ͧ����������
			  global: false,
			  type: "POST",//�ٻẺ�����ŷ�����
			  data:  "ID="+$(this).val()+"&TYPE=Amphur", //data_qampur, //�����ŷ����  { ���͵���� : ��ҵ���� }
			  dataType: "JSON", //�ٻẺ�����ŷ���觡�Ѻ xml,script,json,jsonp,text
			  async:false,
			  success: function(jd) { //�ʴ�����������ͷӧҹ���� ���� each �ͧ jQuery             
                            
							var opt="<option value=\"0\" selected=\"selected\">---���͡�����---</option>";
							$.each(jd, function(key, val){
								opt +="<option value='"+ val['amphur_id']+"'>"+val['amphur_name']+"</option>"
    						});
							$("#aumpher1").html( opt );//�������ŧ� Select �ͧ����� */
		   	  }
		});	
        
        
        $('#PostID').text($(this).val());
        
               
        
    });
});
