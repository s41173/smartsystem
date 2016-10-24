   <?php
      function get_menu($data, $parent = 0)
      {
	      static $i = 1;
	      $tab = str_repeat(" ", $i);
	      if (isset($data[$parent])) {
		      $html = "$tab<ul class='nav side-menu' id=''>";
		      $i++;
		      foreach ($data[$parent] as $v) {
			       $child = get_menu($data, $v->id);
			       $html .= "<ul class=\"nav child_menu\" style=\"display:none\"> $tab<li class=''>";
			       $html .= anchor($v->url, $v->name);
			       if ($child) {
				       $i--;
				       $html .= $child;
				       $html .= "$tab";
			       }
			       $html .= '</li> </ul>';
		      }
		      $html .= "$tab</ul>";
		      return $html;
	      }
              else {return false; }
      }


      $result = mysql_query("SELECT * FROM admin_menu ORDER BY menu_order");
      while ($row = mysql_fetch_object($result)) {
	       $data[$row->parent_id][] = $row;
      }

      $menu = get_menu($data);
      echo "$menu";
    ?>
	
    
    