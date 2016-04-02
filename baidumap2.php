<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
    
	<title>智路管理端——百度地图API</title>  
    <link rel="stylesheet" href="mine.css" type="text/css"/>
    <!--javascript-->  
    <script src="http://www.w3school.com.cn/jquery/jquery.js" type="text/javascript"></script>  
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>  
<!--拾取经纬度：http://api.map.baidu.com/lbsapi/getpoint/index.html?qq-pf-to=pcqq.c2c-->
<body> 
  <div class="demo_main">  
        <fieldset class="demo_title">  
            <h3>百度地图API显示多个标注点</h3>  
			<div id="menu">
			<ul>  
			<li><a href="categories.html">陕西</a>
			<div>        
			<ul>	
			<li><a href="default.htm">西安</a></li>
			<li><a href="default.htm">渭南</a></li>
			<li><a href="default.htm">榆林</a></li>
			<li><a href="default.htm">宝鸡</a></li>
			</ul>
			</div>
			</li>
			<li><a href="categories.html">河南</a>   	
			<div>
			<ul>	
			<li><a href="default.htm">郑州</a></li>
			<li><a href="default.htm">洛阳</a></li>
			<li><a href="default.htm">周口</a></li>
			<li><a href="default.htm">开封</a></li>
			</ul>
			</div>
			</li>
			<li><a href="categories.html">河北</a>
			<div>
			<ul>	
			<li><a href="default.htm">石家庄</a></li>
			<li><a href="default.htm">邯郸</a></li>
			<li><a href="default.htm">唐山</a></li>
			<li><a href="default.htm">张家口</a></li>
			<li><a href="default.htm">保定</a></li>
			</ul>
			</div>
			</li>
			<li><a href="categories.html">北京</a></li>
			<li><a href="categories.html">上海</a></li>
			<li><a href="categories.html">深圳</a></li>
			</ul>
			</div>
        </fieldset> 
       
        <fieldset class="demo_content">  
           <div style="min-height: 600px; width: 100%;" id="map"> </div> 		
           
        </fieldset>  
    </div>  	
	
<?php
$link = mysqli_connect('139.129.11.88','root','123','test'); 
mysqli_query($link,"set names 'utf-8'");//此句为必加项，不然会导致数据库乱码
if (!$link) { 
	die('Could not connect to MySQL: ' . mysqli_error()); 
} 
//echo 'Connection OK'."<br />"; 
//mysql_select_db("test", $link) or die("Can't connect to database");
$arr =  array();
$rs = mysqli_query($link,"select * from `gao`");
while($row = mysqli_fetch_array($rs)){
$arr[] =  $row;  
}
//现在数组arr就是二维数组
$res =  json_encode($arr);	
?>
 		
<script type="text/javascript"> 			
			var markerArr = [  
                    { title: "名称：西北工业大学长安校区", point: "108.771604, 34.038731", address: "西工大", tel: "12306" }
                ];
			//var tArray = new Array();   //先声明一维
            for(var k=1;k<100;k++){        //一维长度为i,i为变量，可以根据实际情况改变  
            markerArr[k]=new Array();    //声明二维，每一个一维数组里面的一个元素都是一个数组
            }	
			var markerArr2 = <?php echo $res ?>; 
			for(var temp in markerArr2){
	            //document.write(markerArr2[temp].CMDID);	
	            markerArr[temp].point=markerArr2[temp].SUserName+","+markerArr2[temp].CMDID; 
				markerArr[temp].title=markerArr2[temp].SResult;
	            //document.write(markerArr[temp].point);
                //}
		    }         		
                var map; //Map实例	 				
                function map_init() { 			
                    map = new BMap.Map("map");  
                    //第1步：设置地图中心点  
                    var point = new BMap.Point(108.75655287171612, 34.037195737054745);  
                    //第2步：初始化地图,设置中心点坐标和地图级别。  
                    map.centerAndZoom(point, 13);  
                    //第3步：启用滚轮放大缩小  
                    map.enableScrollWheelZoom(true);  
                    //第4步：向地图中添加缩放控件  
                    var ctrlNav = new window.BMap.NavigationControl({  
                        anchor: BMAP_ANCHOR_TOP_LEFT,  
                        type: BMAP_NAVIGATION_CONTROL_LARGE  
                    });  
                    map.addControl(ctrlNav);  
                    //第5步：向地图中添加缩略图控件  
                     var ctrlOve = new window.BMap.OverviewMapControl({  
                        anchor: BMAP_ANCHOR_BOTTOM_RIGHT,  
                        isOpen: 1  
                    });  
                    map.addControl(ctrlOve);  
  
                    //第6步：向地图中添加比例尺控件  
                    var ctrlSca = new window.BMap.ScaleControl({  
                        anchor: BMAP_ANCHOR_BOTTOM_LEFT  
                    });  
                    map.addControl(ctrlSca);  
  
                    //第7步：绘制点    
                    for (var i in markerArr) {  
                        var p0 = markerArr[i].point.split(",")[0];  
                        var p1 = markerArr[i].point.split(",")[1]; 						
                        var maker = addMarker(new window.BMap.Point(p0, p1), i);  
                        addInfoWindow(maker, markerArr[i], i);   
                    }  
                }  
  
                // 添加标注  
                function addMarker(point, index) {  
                    var myIcon = new BMap.Icon("http://api.map.baidu.com/img/markers.png",  
                        new BMap.Size(23, 25), {  
                            offset: new BMap.Size(10, 25),  
                            imageOffset: new BMap.Size(0, 0 - index * 25)  
                        });  
                    var marker = new BMap.Marker(point, { icon: myIcon });  
                    map.addOverlay(marker);  
                    return marker;  
                }  
  
                // 添加信息窗口  
                function addInfoWindow(marker, poi) {  
                    //pop弹窗标题  
                    var title = '<div style="font-weight:bold;color:#CE5521;font-size:14px">' + poi.title + '</div>';  
                    //pop弹窗信息  
                    var html = [];  
                    html.push('<table cellspacing="0" style="table-layout:fixed;width:100%;font:12px arial,simsun,sans-serif"><tbody>');  
                    html.push('<tr>');  
                    html.push('<td style="vertical-align:top;line-height:16px;width:38px;white-space:nowrap;word-break:keep-all">地址:</td>');  
                    html.push('<td style="vertical-align:top;line-height:16px">' + poi.address + ' </td>');  
                    html.push('</tr>');  
                    html.push('</tbody></table>');  
                    var infoWindow = new BMap.InfoWindow(html.join(""), { title: title, width: 200 });  
  
                    var openInfoWinFun = function () {  
                        marker.openInfoWindow(infoWindow);  
                    };  
                    marker.addEventListener("click", openInfoWinFun);  
                    return openInfoWinFun;  
                }  
  
                //异步调用百度js  
                function map_load() {  
                    var load = document.createElement("script");  
                    load.src = "http://api.map.baidu.com/api?v=1.4&callback=map_init";  
                    document.body.appendChild(load);  
                }  
                window.onload = map_load;  
</script>

</body>  
</html> 