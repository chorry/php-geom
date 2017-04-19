<?php
/*
* Copyright (c) 1995, 2008, Oracle and/or its affiliates. All rights reserved.
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
 * A point representing a location in {@code (x,y)} coordinate space,
 * specified in integer precision.
 */
class Point extends Point2D
{

    public function __construct()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 0:
                parent::__construct();
                break;
            case 1:
                if ($args[0] instanceof Point) {
                    $this->x = $args[0]->getX();
                    $this->y = $args[0]->getY();
                }
                break;
            case 2:
                $this->x = $args[0];
                $this->y = $args[1];
        }
    }


    /**
     * Returns the location of this point.
     * This method is included for completeness, to parallel the
     * <code>getLocation</code> method of <code>Component</code>.
     * @return  Point    a copy of this point, at the same location
     * @see         java.awt.Component#getLocation
     * @see         java.awt.Point#setLocation(java.awt.Point)
     * @see         java.awt.Point#setLocation(int, int)
     */
    public function getLocation()
    {
        return new Point($this->getX(), $this->getY());
    }

    public function setLocation()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 1:
                $this->setLocationByPoint($args[0]);
                break;
            case 2:
                $this->setLocationByXY($args[0], $args[1]);
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Sets the location of the point to the specified location.
     * This method is included for completeness, to parallel the
     * <code>setLocation</code> method of <code>Component</code>.
     * @param       Point $p a point, the new location for this point
     * @since       1.1
     */
    private function setLocationByPoint(Point $p)
    {
        $this->move($p->getX(), $p->getY());
    }

    /**
     * Changes the point to have the specified location.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setLocation</code> method of <code>Component</code>.
     * Its behavior is identical with <code>move(int,&nbsp;int)</code>.
     * @param       float $x the X coordinate of the new location
     * @param       float $y the Y coordinate of the new location
     * @see         java.awt.Component#setLocation(int, int)
     * @see         java.awt.Point#getLocation
     * @see         java.awt.Point#move(int, int)
     * @since       1.1
     */
    private function setLocationByXY($x, $y)
    {
        $this->move($x, $y);
    }

    /**
     * Moves this point to the specified location in the
     * {@code (x,y)} coordinate plane. This method
     * is identical with <code>setLocation(int,&nbsp;int)</code>.
     * @param       float $x the X coordinate of the new location
     * @param       float $y the Y coordinate of the new location
     * @see         java.awt.Component#setLocation(int, int)
     */
    public function move($x, $y)
    {
        $this->x = (int)floor($x + 0.5);
        $this->y = (int)floor($y + 0.5);
    }

    /**
     * Translates this point, at location {@code (x,y)},
     * by {@code dx} along the {@code x} axis and {@code dy}
     * along the {@code y} axis so that it now represents the point
     * {@code (x+dx,y+dy)}.
     *
     * @param  float $dx the distance to move this point
     *                            along the X axis
     * @param  float $dy the distance to move this point
     *                            along the Y axis
     */
    public function translate($dx, $dy)
    {
        $this->move($this->getX() + $dx, $this->getY() + $dy);
    }

    /**
     * Determines whether or not two points are equal. Two instances of
     * <code>Point2D</code> are equal if the values of their
     * <code>x</code> and <code>y</code> member fields, representing
     * their position in the coordinate space, are the same.
     * @param Object $obj an object to be compared with this <code>Point2D</code>
     * @return <code>true</code> if the object to be compared is
     *         an instance of <code>Point2D</code> and has
     *         the same values; <code>false</code> otherwise.
     */
    public function equals($obj)
    {
        if ($obj instanceof Point) {
            return ($this->getX() === $obj->getX()) && ($this->getY() === $obj->getY());
        }
        return $this === $obj;
    }

    /**
     * Returns a string representation of this point and its location
     * in the {@code (x,y)} coordinate space. This method is
     * intended to be used only for debugging purposes, and the content
     * and format of the returned string may vary between implementations.
     * The returned string may be empty but may not be <code>null</code>.
     *
     * @return string a string representation of this point
     */
    public function __toString()
    {
        return sprintf("%s [x=%s,y=%s]", get_class($this), $this->getX(), $this->getY());
    }
}