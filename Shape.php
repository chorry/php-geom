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

//https://docs.oracle.com/javase/7/docs/api/java/awt/Shape.html
interface Shape
{
    /**
     * Factory method for realization of overloaded `contains()`
     * @return bool
     */
    public function contains();

    /**
     * Tests if the specified coordinates are inside the boundary of the Shape, as described by the definition of insideness.
     * @param $x
     * @param $y
     * @return bool
     */
    public function contains2Params($x, $y);

    /**
     * Tests if the interior of the Shape entirely contains the specified rectangular area.
     * @param double $x
     * @param double $y
     * @param double $w
     * @param double $h
     * @return bool
     */
    public function contains4Params($x, $y, $w, $h);

    /**
     * Tests if a specified Point2D is inside the boundary of the Shape, as described by the definition of insideness.
     * @param Point2D $
     * @return bool
     */
    public function containsPoint(Point2D $p);

    /**
     * Tests if the interior of the Shape entirely contains the specified Rectangle2D.
     * @param Rectangle2D $r
     * @return bool
     */
    public function containsRectangle(Rectangle2D $r);

    /**
     * Returns an integer Rectangle that completely encloses the Shape.
     * @return Rectangle
     */
    public function getBounds();

    /**
     * Returns a high precision and more accurate bounding box of the Shape than the getBounds method.
     * @return Rectangle2D
     */
    public function getBounds2D();

    /**
     * Factory method for overloaded `getPathIterator`
     * @return PathIterator
     */
    public function getPathIterator();

    /**
     * Returns an iterator object that iterates along the Shape boundary and provides access to the geometry of the Shape outline.
     * @param AffineTransform $at
     * @return PathIterator
     */
	public function getPathIteratorByAT(AffineTransform $at);

    /**
     * Returns an iterator object that iterates along the Shape boundary and provides access to a flattened view of the Shape outline geometry.
     * @param AffineTransform $at
     * @param $flatness
     * @return PathIterator
     */
    public function getPathIteratorByATAndFlatness(AffineTransform $at, $flatness);


    /**
     * Factory method for realization of overloaded `intersects()`
     * @return bool
     */
    public function intersects();

    /**
     * Tests if the interior of the Shape intersects the interior of a specified rectangular area.
     * @param double $x
     * @param double $y
     * @param double $w
     * @param double $h
     * @return bool
     */
    public function intersects4Params($x, $y, $w, $h);

    /**
     * Tests if the interior of the Shape intersects the interior of a specified Rectangle2D.
     * @return bool
     */
    public function intersectsRectangle2D(Rectangle2D $r);

}