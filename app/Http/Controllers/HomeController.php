<?php
namespace App\Http\Controllers;

use App\Parsedown;
use Illuminate\Http\Request;
use App\Http\Requests;

class HomeController extends Controller
{
    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters); // TODO: Change the autogenerated stub
    }

    public function floatingNavigationBar()
    {
        $a = '# My article
 Welcome to my article,
* Point one
* Point two
* Point three
```
<?php
foreach(range(1,10) as $k){
echo $x;
}
?>
```
Here is some echo `\'inline code\'`;';
        $fileContent = '';
        $time = 0;
        /*get directory of file*/
        $handle = fopen(public_path('jdy.txt'), 'r');

        /*add a anchor to each title and then use javascript to Automatically generate directory*/
        while (!feof($handle)) {
            $lineStr = fgets($handle);
            if (substr($lineStr, 0, 1) == '#') {

                if (substr($lineStr, 0, 4) == '####') {
                    /*this is h4*/
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 3) == '###' && substr($lineStr, 0, 4) != '####') {
                    /*this is h3*/
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 2) == '##' && substr($lineStr, 0, 3) != '###') {
                    /*this is h2*/
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 1) == '#' && substr($lineStr, 0, 2) != '##') {
                    /*this is h1*/
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }

            } else {
                $fileContent .= $lineStr;
            }

        }

        fclose($handle);
        $b = Parsedown::instance()->text($fileContent);

        return view('blog.index', ['text' => $b]);

    }

    public function fixedTheNavigationBar()
    {
        $a = '# My article
 Welcome to my article,
* Point one
* Point two
* Point three
```
<?php
foreach(range(1,10) as $k){
echo $x;
}
?>
```
Here is some echo `\'inline code\'`;';
        $fileContent = '';
        $time = 0;
        $h_value=array(); //store h value and title name

        /*get directory of file*/
        $handle = fopen(public_path('jdy.txt'), 'r');
        /*add a anchor to each title and then use javascript to Automatically generate directory*/
        while (!feof($handle)) {
            $lineStr = fgets($handle);
            if (substr($lineStr, 0, 1) == '#') {

                if (substr($lineStr, 0, 6) == '######') {
                    /*this is h6*/
                    $tmp[0]=6;
                    $tmp[1]=substr($lineStr,6);
                    $h_value[]=$tmp;
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 5) == '#####'&&substr($lineStr, 0, 6) != '######') {
                    /*this is h5*/
                    $h_value[]=5;
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 4) == '####'&&substr($lineStr, 0, 5) != '#####') {
                    /*this is h4*/
                    $h_value[]=4;
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 3) == '###' && substr($lineStr, 0, 4) != '####') {
                    /*this is h3*/
                    $h_value[]=3;
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 2) == '##' && substr($lineStr, 0, 3) != '###') {
                    /*this is h2*/
                    $h_value[]=2;
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }
                if (substr($lineStr, 0, 1) == '#' && substr($lineStr, 0, 2) != '##') {
                    /*this is h1*/
                    $h_value[]=1;
                    $anchor = '<p><a name=' . $time . '></a></p>';
                    $fileContent .= $anchor . "\n";
                    $fileContent .= $lineStr;
                    $time++;
                }

            } else {
                $fileContent .= $lineStr;
            }

        }

        fclose($handle);
        $b = Parsedown::instance()->text($fileContent);

       // $arr_length=count($h_value);
        $str=array();
        $str_length=0; //str array element number
        foreach ($h_value as $k=>$value){
            $title="<a href=#  style=text-decoration:none>$value[1]</a>";
            $key=$k;
            $folder=false;
            $children="";
            $tmp=array('title'=>$title,'key'=>$key,'folder'=>$folder,'children'=>$children);
           $current_level=$h_value[$k][0];
            /*是平级*/
           if($current_level==$h_value[$str[$str_length]['key']][0]){
               $str[]=$tmp;
               $str_length++;
           }
            /*是平级*/
            if($current_level<$h_value[$str[$str_length]['key']][0]){
                $str[]=$tmp;
                $str_length++;
            }

           /*是后代*/
            if($current_level>$h_value[$str[$str_length]['key']][0]){
                $tp=&$str[$str_length]['children'];

                while (is_array($tp)){
                    $tp_length=count($tp);
                    if($current_level<=$h_value[$tp[$tp_length-1]['key']][0]){
                        $tp=$tmp;
                        break;
                    }
                    $tp=&$tp[$tp_length-1]['children'];
                }

                if(!is_array($tp)){
                    $tp=$tmp;
                }


            }

        }

        $str2=json_encode($str);
        $s = '[
            {"title": "<a href=#  style=text-decoration:none>Node 1</a>", "key": "1"},
            {"title": "Folder 2", "key": "2", "folder": true,
                     "children": 
                           [
                            {"title": "Node 2.1", "key": "3"},  
                             {"title": "Node 2.2", "key": "4"} 
                                ]}            
                                     ]';

        return view('blog.fixTheNavBar', ['text' => $b,'tree'=>$str2]);

    }

    public function modifyNodeName(Request $request){

    }

    public function adjustNodePlace(Request $request){
        $str = '[
                {"title": "Node 1", "key": "1"},
                {"title": "Folder 2", "key": "2", "folder": true, "children": [
                    {"title": "Node 2.1", "key": "3"},
                    {"title": "Node 2.2", "key": "4"}
                ]}
                    ]';
        $str=json_decode($str);  //get a array


    }

    public function addNewNode(Request $request){

    }


    public function deleteNode(Request $request){

    }

}
