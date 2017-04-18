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
 * A utility class to iterate over the path segments of a rectangle
 * through the PathIterator interface.
 *
 * @author      Jim Graham
 */
class RectIterator implements PathIterator
{
    /**
     * @var float
     */
    private $x, $y, $w, $h;
    /**
     * @var AffineTransform
     */
    private $affine;
    /**
     * @var int
     */
    private $index;

    public function __construct(Rectangle2D $r, AffineTransform $at)
    {
        $this->x = $r->getX();
        $this->y = $r->getY();
        $this->w = $r->getWidth();
        $this->h = $r->getHeight();
        $this->affine = $at;
        if ($this->w < 0 || $this->h < 0) {
            $this->index = 6;
        }
    }

    /**
     * Return the winding rule for determining the insideness of the
     * path.
     * @see #self::WIND_EVEN_ODD
     * @see #self::WIND_NON_ZERO
     */
    public function getWindingRule()
    {
        return self::WIND_NON_ZERO;
    }

    /**
     * Tests if there are more points to read.
     * @return true if there are more points to read
     */
    public function isDone()
    {
        return $this->index > 5;
    }

    /**
     * Moves the iterator to the next segment of the path forwards
     * along the primary direction of traversal as long as there are
     * more points in that direction.
     */
    public function next()
    {
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
            throw new NoSuchElementException("rect iterator out of bounds");
        }
        if ($this->index == 5) {
            return self::SEG_CLOSE;
        }
        $coords[0] = (float)$this->x;
        $coords[1] = (float)$this->y;
        if ($this->index == 1 || $this->index == 2) {
            $coords[0] += (float)$this->w;
        }
        if ($this->index == 2 || $this->index == 3) {
            $coords[1] += (float)$this->h;
        }
        if ($this->affine != null) {
            $this->affine->transform($coords, 0, $coords, 0, 1);
        }
        return ($this->index == 0 ? self::SEG_MOVETO : self::SEG_LINETO);
    }
}

