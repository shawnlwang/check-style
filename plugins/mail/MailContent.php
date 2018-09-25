<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<title>AMS-CGI-REPORT</title>
</head>
<body style="font-size:12px;">
<P style="padding: 0px 0px 5px; width: 800px; font-weight:bold; text-align: left;font-size: 16px;" >编码规范检查报告</P>
<P style="padding: 0px 0px 5px; width: 800px; text-align: left;font-size: 14px;" >以下项违反代码规范，请关注，<a href="">详细规范请查看</a></P>
        <?php
            foreach ($GLOBALS["result"] as $rule => $item) {
                echo "
        <table id='mytable' cellspacing='0' style='width:1200px;magin-top:30px; font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255); border: 1px solid rgb(41, 119, 176); border-collapse: collapse; line-height: 140%;'>
            <caption style='margin: 10px 0; padding: 0px 0px 5px; width: 1200px; text-align: left;' >规则：{$rule}（{$GLOBALS['ruleAnnotation'][$rule]}）</caption>
            <tr style='font-family: 微软雅黑; font-size: 14px; background-color: rgb(213, 231, 243); color: rgb(68, 68, 68); height: 26px; white-space: nowrap;'>
                <th style='font-family: 微软雅黑; font-size: 14px; border: 1px solid rgb(141, 185, 219); border-collapse: collapse; padding-left: 8px; padding-left: 8px; white-space: nowrap;'>摘要</th>
                <th style='font-family: 微软雅黑; font-size: 14px; border: 1px solid rgb(141, 185, 219); border-collapse: collapse; padding-left: 8px; padding-left: 8px; white-space: nowrap;'>位置</th>
                <th style='font-family: 微软雅黑; font-size: 14px; border: 1px solid rgb(141, 185, 219); border-collapse: collapse; padding-left: 8px; padding-left: 8px; white-space: nowrap;'>详情</th>
            </tr>";
                foreach ($item as $val) {
                    echo '<tr style="font-family: 微软雅黑; font-size: 14px;background-attachment: scroll; background-color: rgb(252, 253, 253); height: 26px;">
                            <td  style="font-family: 微软雅黑; background-color: rgb(213, 231, 243); font-size: 14px; border: 1px solid rgb(141, 185, 219); border-collapse: collapse;color: rgb(68, 68, 68); padding: 0px 8px;">' . preg_replace('[&|\|]', "<br>", $val['digest']) . '</td>
			                <td  style="font-family: 微软雅黑; background-color: rgb(213, 231, 243); font-size: 14px; border: 1px solid rgb(141, 185, 219); border-collapse: collapse;color: rgb(68, 68, 68); padding: 0px 8px;">' . preg_replace('[&|\|]', "<br>", $val["position"]) . '</td>
			                <td style="font-family: 微软雅黑; font-size: 14px; text-align:left; border: 1px solid rgb(141, 185, 219); border-collapse: collapse; color: rgb(46, 110, 158); padding: 0px 8px;word-break:break-all; word-wrap: break-all;">' . preg_replace('[(' . PHP_EOL . ')|\|]', "<br>", $val['detail']) . '</td>
                       </tr>';
                }
            }
        ?>
</table>
<br/>
如有疑问，请咨询shawn<br/>
</body>
</html>