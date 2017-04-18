<?php
/*
 * Copyright (c) 1997, Oracle and/or its affiliates. All rights reserved.
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS FILE HEADER.
 *
 * This code is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License version 2 only, as
 * published by the Free Software Foundation.  Oracle designates this
 * particular file as subject to the "Classpath" exception as provided
 * by Oracle in the LICENSE file that accompanied this code.
 *
 * This code is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
 * version 2 for more details (a copy is included in the LICENSE file that
 * accompanied this code).
 *
 * You should have received a copy of the GNU General Public License version
 * 2 along with this work; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * Please contact Oracle, 500 Oracle Parkway, Redwood Shores, CA 94065 USA
 * or visit www.oracle.com if you need additional information or have any
 * questions.
 */


/**
 * A utility class to iterate over the path segments of an rounded rectangle
 * through the PathIterator interface.
 *
 * @author      Jim Graham
 */
class RoundRectIterator implements PathIterator {
    /**
     * @var float
     */
    private $x, $y, $w, $h, $aw, $ah;
    /**
     * @var AffineTransform
     */
    private $affine;
    /**
     * @var int
     */
    private $index;

    private static $angle;
    private static $a;
    private static $b;
    private static $c;
    private static $cv;
    private static $acv;
    private static $ctrlpts;
    private static $types = [
        self::SEG_MOVETO,
        self::SEG_LINETO, self::SEG_CUBICTO,
        self::SEG_LINETO, self::SEG_CUBICTO,
        self::SEG_LINETO, self::SEG_CUBICTO,
        self::SEG_LINETO, self::SEG_CUBICTO,
        self::SEG_CLOSE,
    ];

    public function __construct(RoundRectangle2D $rr, AffineTransform $at)
    {
        $this->x = $rr->getX();
        $this->y = $rr->getY();
        $this->w = $rr->getWidth();
        $this->h = $rr->getHeight();
        $this->aw = min($this->w, abs($rr->getArcWidth()));
        $this->ah = min($this->h, abs($rr->getArcHeight()));
        $this->affine = $at;
        if ($this->aw < 0 || $this->ah < 0) {
            // Don't draw anything...
            $this->index = count(static::$ctrlpts);
        }
        $this->initStatics();
    }

    private function initStatics()
    {
        static::$angle = pi() / 4.0;
        static::$a = 1.0 - cos(static::$angle);
        static::$b = tan(static::$angle);
        static::$c = sqrt(1.0 + static::$b * static::$b) - 1 + static::$a;
        static::$cv = 4.0 / 3.0 * static::$a * static::$b / static::$c;
        static::$acv = (1.0 - static::$cv) / 2.0;

        // For each array:
        //     4 values for each point {v0, v1, v2, v3}:
        //         point = (x + v0 * w + v1 * arcWidth,
        //                  y + v2 * h + v3 * arcHeight);

        static::$ctrlpts = [
        [  0.0,  0.0,  0.0,  0.5 ],
        [  0.0,  0.0,  1.0, -0.5 ],
        [  0.0,  0.0,  1.0, -static::$acv,
            0.0,  static::$acv,  1.0,  0.0,
            0.0,  0.5,  1.0,  0.0 ],
        [  1.0, -0.5,  1.0,  0.0 ],
        [  1.0, -static::$acv,  1.0,  0.0,
            1.0,  0.0,  1.0, -static::$acv,
            1.0,  0.0,  1.0, -0.5 ],
        [  1.0,  0.0,  0.0,  0.5 ],
        [  1.0,  0.0,  0.0,  static::$acv,
            1.0, -static::$acv,  0.0,  0.0,
            1.0, -0.5,  0.0,  0.0 ],
        [  0.0,  0.5,  0.0,  0.0 ],
        [  0.0,  static::$acv,  0.0,  0.0,
            0.0,  0.0,  0.0,  static::$acv,
            0.0,  0.0,  0.0,  0.5 ],
        [],
    ];
    }
    /**
     * Return the winding rule for determining the insideness of the
     * path.
     * @see self::WIND_EVEN_ODD
     * @see self::WIND_NON_ZERO
     */
    public function getWindingRule() {
        return self::WIND_NON_ZERO;
    }

    /**
     * Tests if there are more points to read.
     * @return true if there are more points to read
     */
    public function isDone() {
        return $this->index >= count(static::$ctrlpts);
    }

    /**
     * Moves the iterator to the next segment of the path forwards
     * along the primary direction of traversal as long as there are
     * more points in that direction.
     */
    public function next() {
        $this->index++;
    }


    /**
     * Returns the coordinates and type of the current path segment in
     * the iteration.
     * The return value is the path segment type:
     * SEG_MOVETO, SEG_LINETO, SEG_QUADTO, SEG_CUBICTO, or SEG_CLOSE.
     * A float array of length 6 must be passed in and may be used to
     * store the coordinates of the point(s).
     * Each point is stored as a pair of float x,y coordinates.
     * SEG_MOVETO and SEG_LINETO types will return one point,
     * SEG_QUADTO will return two points,
     * SEG_CUBICTO will return 3 points
     * and SEG_CLOSE will not return any points.
     * @param float[] $coords
     * @see self::SEG_MOVETO
     * @see self::SEG_LINETO
     * @see self::SEG_QUADTO
     * @see self::SEG_CUBICTO
     * @see self::SEG_CLOSE
     */
    public function currentSegment($coords)
    {
        if ($this->isDone()) {
            throw new NoSuchElementException("roundrect iterator out of bounds");
        }
        $ctrls[] = static::$ctrlpts[$this->index];
        $nc = 0;
        for ($i = 0; $i < count($ctrls); $i += 4) {
            $coords[$nc++] = (float)($this->x + $ctrls[$i + 0] * $this->w + $ctrls[$i + 1] * $this->aw);
            $coords[$nc++] = (float)($this->y + $ctrls[$i + 2] * $this->h + $ctrls[$i + 3] * $this->ah);
        }
        if ($this->affine != null) {
            $this->affine->transform($coords, 0, $coords, 0, $nc / 2);
        }
        return static::$types[$this->index];
    }
}