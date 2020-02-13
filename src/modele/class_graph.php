<?php

class Graphique {

    public function __construct($db) {
        $this->db = $db;
    }

    public function top($dataly, $type) {
        $image = null;
        $graph = null;
        if ($type == 'barres') {
            $graph = $this->barres($dataly);
        } else {
            $graph = $this->Pie($dataly);
        }
        if ($graph != null) {

            $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

            ob_start();

            $graph->img->Stream();

            $image_data = ob_get_contents();

            ob_end_clean();

            $image = base64_encode($image_data);
        } else {
            echo 'null';
        }
        return $image;
    }

    public function Barres($data1y) {

        $graph = new Graph(1000, 800, 'auto');
        $graph->SetScale("textlin");

        $theme_class = new UniversalTheme;
        $graph->SetTheme($theme_class);

        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'));
        $graph->yaxis->HideLine(false);

        $b1plot = new BarPlot($data1y);

        $gbplot = new GroupBarPlot(array($b1plot));


        $graph->Add($gbplot);

        $b1plot->SetColor("white");
        $b1plot->SetFillColor("#2056ac");

        return $graph;
    }

    public function Pie($data) {

        $graph = new PieGraph(1000, 800);

        $graph->SetFrame(false);


        $theme_class = new VividTheme;
        $graph->SetTheme($theme_class);


        $p1 = new PiePlot3D($data);
        $graph->Add($p1);



        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->ExplodeSlice(1);
        return $graph;
    }

}

?>
