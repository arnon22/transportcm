 //**** กำหนดขนาด Space ของ Footer
            $height_of_cell = 30; // mm
            $page_height = 210; // mm (portrait letter)
            $bottom_margin = 0; // mm


อยู่ใน Loop foreach(){
/*กำหนดค่า Space ด้าน ด้านซ้าย*/
$space_left = $page_height - ($this->pdf->GetY() + $bottom_margin); // space left on page

if ($height_of_cell > $space_left) {

}
                }