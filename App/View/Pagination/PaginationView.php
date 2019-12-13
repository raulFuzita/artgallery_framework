<?php

namespace App\View\Pagination;

class PaginationView {
    
    private $pgNumber = 10;
    
    public function bootstrapPagination($currentPage, $dataSize){

        $currentPage = intval($currentPage);
        $dataSize = intval($dataSize);
        $totalPages = ($dataSize > $this->pgNumber) ? ceil($dataSize/ $this->pgNumber) : 1;
        $initPage = 0;
        $endPage = 0;

        if($currentPage <= $dataSize){

            if($totalPages > 4){
    
                if(($currentPage % $this->pgNumber) > 0){
                    $initPage = ($currentPage - ($currentPage % $this->pgNumber)) + 1;
                } else {
                    $initPage = $currentPage;
                }
            } else {
                $initPage = 1;
            }
    
            echo "<nav aria-label='...'>
                <ul class='pagination'>".
                    "<li class='page-item ".
                        (($currentPage < 2) ? "disabled" : "")."'>
                        <a id='previous-page' class='page page-link' href='#' tabindex='-1'>Previous</a>
                    </li>";
    
            // ============= LOGIC =================================
    
            $endPage = (($initPage+3) < $totalPages) ? ($initPage+3) : $totalPages;

            $focus = ($currentPage < 1) ? 1: $currentPage;

            for($i=$initPage; $i <= $endPage; $i++){
    
                if($i == $focus){
                    echo "<li class='page-item active'>
                    <a id='$i' class='page page-link' href='#'>$i<span class='sr-only'>(current)</span></a>
                    </li>";
                } else {
                    echo "<li class='page-item'><a id='$i' class='page page-link' href='#'>$i</a></li>";
                }
                
            }
    
            // =====================================================
    
            echo "<li class='page-item ". 
                    (($currentPage < ($totalPages) AND $totalPages > 1) ? "" : "disabled") . "'>".
                                "<a id='next-page' class='page page-link' href='#'>
                                    Next
                                </a>
                            </li></ul></nav>";
            
            return true;
        }
        echo "Pagination failed!";
        return false;
    } // End of Bootstrap Pagination
    
    public function getPageNumber(){return $this->pgNumber;}
    public function setPageNumber($pgNumber){
        $this->pgNumber = $pgNumber;
    }
}