<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Aplikasi Loader Library
 * Library untuk mengambil session, generate menu dll
 * @author  Yogi Kaputra
 * @since   1.0
 */

class App_loader
{
  public function __construct()
  {
    $this->CI = & get_instance();
  }

  /*--------------------------------User Properties---------------------------*/
  public function current_account() {
    $account_user = $this->CI->session->userdata('account_name');
    return $account_user;
  }

  public function current_name() {
    $account_name = $this->CI->session->userdata('fullname');
    return $account_name;
  }

  public function current_nickname(){
    $nickname = explode(" ", $this->current_name());
    return $nickname[0];
  }

  public function current_group() {
    $id_group = $this->CI->session->userdata('group_active');
    return $id_group;
  }

  public function current_group_name()
  {
    $group_name = $this->CI->session->userdata('group_name');
    return $group_name;
  }

  public function current_instansi()
  {
    $instansi = $this->CI->session->userdata('instansi');
    return $instansi;
  }

  /**
   * Fungsi untuk mengecek level yang sedang login apakah sebagai Superadmin
   * @return boolean
   */
  public function is_admin() {
    if ($this->CI->session->userdata('nick_level') == 'SAD') {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Fungsi untuk mengecek level yang sedang login apakah sebagai admin lokal
   * @return boolean
   */
  public function is_operator() {
    if ($this->CI->session->userdata('nick_level') == 'ADL') {
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Fungsi untuk mengecek level yang sedang login apakah sebagai admin lokal
   * @return boolean
   */
  public function is_administrator() {
    if ($this->CI->session->userdata('nick_level') == 'ADM') {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Fungsi untuk mengecek user yang login apakah sebagai Pimpinan
   * @return boolean
   */
  public function is_pimpinan() {
    if ($this->CI->session->userdata('nick_level') == 'GUB') {
      return TRUE;
    }
    return FALSE;
  }
  /*-------------------------------Generate Menu------------------------------*/

  public function create_menu()
  {
    $this->CI->load->model(array('signin/model_generate_menu' => 'mgm'));
    $menus = $this->CI->mgm->getDataMenu();
    ///membuat multidimensional array
    $menu = array(
        'items' => array(), //untuk menampung item
        'parents' => array()//untuk menampung parent
    );
    foreach ($menus as $items) {
      $menu['items'][$items['parent_id']][] = $items['order_menu'];
      $menu['parents'][$items['parent_id']][$items['order_menu']] = $items;
    }
    return $this->generate_menu(0, $menu);
  }

  public function generate_menu($parent, $menu)
  {
    $html = '';
    if(isset($menu['items'][$parent])) {
      sort($menu['items'][$parent]);
      foreach ($menu['items'][$parent] as $key) {
        $idMenu = $menu['parents'][$parent][$key]['id_menu'];
        $title  = $menu['parents'][$parent][$key]['title_menu'];
        $icon   = $menu['parents'][$parent][$key]['icon_menu'];
        $link   = $menu['parents'][$parent][$key]['url_menu'];
        $url    = ($link == '#') ? 'javascript:;' : $link;

        if($menu['parents'][$parent][$key]['is_parent'] == 'N') {
          if($icon != '')
            $html .= '<li><a href="'.site_url($url).'"><i class="'.$icon.'"></i> <span>'.$title.'</span></a></li>';
          else
            $html .= '<li><a href="'.site_url($url).'"><span>'.$title.'</span></a></li>';
        } else {
          if($icon != '')
            $html .= '<li><a href="'.$url.'" class="dropdown-toggle" data-toggle="dropdown"><i class="'.$icon.'"></i> <span>'.$title.' <i class="fa fa-angle-down"></i></span></a>';
          else
            $html .= '<li class="dropdown"><a href="'.$url.'" class="dropdown-toggle" data-toggle="dropdown"><span>'.$title.' <i class="fa fa-angle-down"></i></span></a>';
          $html .= '<ul class="dropdown-menu">';
          $html .= $this->generate_menu($idMenu, $menu);
          $html .= '</ul>';
          $html .= '</li>';
        }
      }
    }
    return $html;
  }
}


// This is the end of App_Loader
