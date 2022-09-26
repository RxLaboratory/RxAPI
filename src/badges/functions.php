<?php
    /*
        RxAPI
        
        This program is licensed under the GNU General Public License.

        Copyright (C) 2020-2022 Nicolas Dufresne and Contributors.

        This program is free software;
        you can redistribute it and/or modify it
        under the terms of the GNU General Public License
        as published by the Free Software Foundation;
        either version 3 of the License, or (at your option) any later version.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
        See the GNU General Public License for more details.

        You should have received a copy of the *GNU General Public License* along with this program.
        If not, see http://www.gnu.org/licenses/.
    */

    require_once $__ROOT__ . '/svg/autoloader.php';
    require_once $__ROOT__ . '/functions.php';

    use SVG\SVG;
    use SVG\Nodes\Shapes\SVGRect;
    use SVG\Nodes\Texts\SVGText;
    use SVG\Nodes\Structures\SVGGroup;
    use SVG\Nodes\Structures\SVGFont;
    use SVG\Nodes\Embedded\SVGImage;

    function badge($labelTxt, $valueTxt, $color='neutral', $icon=null, $small=false) {
        global $__ROOT__;
        
        $badgeColors = array(
            'ok' => '#4bbc4b',
            'info' => '#4c7ed6',
            'yellow' => '#eeaa55',
            'warning' => '#dd8b3b',
            'danger' => '#c4021f',
            'rx' => '#4526c4',
            'neutral' => '#636363',
        );

        $hasIcon = $icon && $icon != "";

        // image
        if ($small)
            $image = new SVG(182,18);
        else
            $image = new SVG(222,28);
        
        $doc = $image->getDocument();

        // Backrground
        $bg = new SVGGroup();
        $bg->setStyle('shape-rendering', 'crispEdges');
        $doc->addChild($bg);

        // label rectangle
        if ($small)
            $labelRect = new SVGRect(0, 0, 102, 18);
        else
            $labelRect = new SVGRect(0, 0, 122, 28);
        $labelRect->setStyle('fill', '#434343');
        $bg->addChild($labelRect);

        // Value rectangle
        $col = $badgeColors['neutral'];
        if ($color != "") {
            if (substr($color, 0, strlen($color)) === "#")
                $col = $color;
            else
                $col = $badgeColors[$color];
        }

        if ($small)
            $valueRect = new SVGRect(102, 0, 80, 18);
        else
            $valueRect = new SVGRect(122, 0, 100, 28);
        
        $valueRect->setStyle('fill', $col);
        $bg->addChild($valueRect);

        // Foreground
        $fg = new SVGGroup();
        $fg->setStyle('font-family', 'Verdana,Geneva,DejaVu Sans,sans-serif');
        $fg->setStyle('text-rendering', 'geometricPrecision');
        $fg->setStyle('font-size', '10px');
        $doc->addChild($fg);

        // Icon
        if ($icon && $icon != "") {

            $icon = SVG::fromFile("{$__ROOT__}/badges/icons/{$icon}.svg");
            $iconSVG = $icon->getDocument();

            // Compute scale
            $height = (int)$iconSVG->getAttribute("height");
            if ($small) $scale = 14/$height;
            else $scale = 18/$height;

            $iconGroup = new SVGGroup();
            $iconGroup->addChild( $iconSVG );
            if ($small) $iconGroup->setAttribute('transform', "translate(5, 2) scale({$scale})");
            else $iconGroup->setAttribute('transform', "translate(10, 4) scale({$scale})");
            $fg->addChild($iconGroup);
        }

        // label
        $y = 18;
        $x = 72;
        if (!$hasIcon) $x = $x - 11;
        if ($small) {
            $x = $x - 10;
            $y = $y - 5;
        }
        $label = new SVGText($labelTxt, $x, $y);
        $label->setStyle('text-anchor', 'middle');
        $label->setStyle('fill', '#e3e3e3');
        $fg->addChild($label);

        // value
        if ($small) $x = $x + 80;
        else $x = $x + 100;
        $val = new SVGText($valueTxt, $x, $y);
        $val->setStyle('text-anchor', 'middle');
        $val->setStyle('fill', '#fff');
        $val->setStyle('font-weight', 'bold');
        $fg->addChild($val);

        header('Content-Type: image/svg+xml');
        echo $image;
    }
?>