<?php
/** Copyright (c) 1997, 2011, Oracle and/or its affiliates. All rights reserved.
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
 * The <code>Point2D</code> class defines a point representing a location
 * in {@code (x,y)} coordinate space.
 * <p>
 * This class is only the abstract superclass for all objects that
 * store a 2D coordinate.
 * The actual storage representation of the coordinates is left to
 * the subclass.
 *
 * @author      Jim Graham
 * @since 1.2
 */
class Point2D
{

    /**
     * The X coordinate of this <code>Point2D</code>.
     */
    public $x;

    /**
     * The Y coordinate of this <code>Point2D</code>.
     */
    public $y;

    /**
     * Constructs and initializes a <code>Point2D</code> with
     * coordinates (0, 0).
     */
    public function __construct()
    {
        $this->x = $this->y = 0;
    }


    /**
     * Returns the X coordinate of this <code>Point2D</code> in
     * <code>double</code> precision.
     * @return float the X coordinate of this <code>Point2D</code>.
     * @since 1.2
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Returns the Y coordinate of this <code>Point2D</code> in
     * <code>double</code> precision.
     * @return float the Y coordinate of this <code>Point2D</code>.
     * @since 1.2
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Sets the location of this <code>Point2D</code> to the
     * specified <code>float</code> coordinates.
     * Accepts:
     * * float $x, float $y
     * * Point2D
     */
    public function setLocation()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                $this->setLocationByXY($args[0], $args[1]);
                break;
            case 1:
                $this->setLocationByPoint($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid arguments count');
        }
    }

    /**
     * Sets the location of this <code>Point2D</code> to the
     * specified <code>float</code> coordinates.
     *
     * @param float $x the new X coordinate of this {@code Point2D}
     * @param float $y the new Y coordinate of this {@code Point2D}
     */
    private function setLocationByXY($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Sets the location of this <code>Point2D</code> to the same
     * coordinates as the specified <code>Point2D</code> object.
     * @param Point2D $p the specified <code>Point2D</code> to which to set
     * this <code>Point2D</code>
     */
    private function setLocationByPoint(Point2D $p)
    {
        $this->setLocation($p->getX(), $p->getY());
    }

    /**
     * Returns a <code>String</code> that represents the value
     * of this <code>Point2D</code>.
     * @return string a string representation of this <code>Point2D</code>.
     * @since 1.2
     */
    public function __toString()
    {
        return sprintf("Point2D[%s,%s]", $this->x, $this->y);
    }

    /**
     * Accepts:
     * * float $x1, float $y1, float $x2, float $y2 - Returns the distance between two points.
     * * float $x, float $y - Returns the distance to this point
     */
    public function distanceSq()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->distanceSqBetweenTwoPoints($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                $this->distanceSqToXY($args[0], $args[1]);
                break;
            case 1:
                $this->distanceSqToPoint($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid argument count');
        }
    }

    /**
     * Returns the square of the distance from this
     * <code>Point2D</code> to a specified point.
     *
     * @param float $px the X coordinate of the specified point to be measured
     *           against this <code>Point2D</code>
     * @param float $py the Y coordinate of the specified point to be measured
     *           against this <code>Point2D</code>
     * @return float the square of the distance between this
     * <code>Point2D</code> and the specified point.
     */
    private function distanceSqToXY($px, $py)
    {
        $px -= $this->getX();
        $py -= $this->getY();
        return ($px * $px + $py * $py);
    }

    /**
     * Returns the square of the distance between two points.
     *
     * @param float $x1 the X coordinate of the first specified point
     * @param float $y1 the Y coordinate of the first specified point
     * @param float $x2 the X coordinate of the second specified point
     * @param float $y2 Y coordinate of the second specified point
     * @return float the square of the distance between the two
     * sets of specified coordinates.
     */
    private function distanceSqBetweenTwoPoints($x1, $y1, $x2, $y2)
    {
        $x1 -= $x2;
        $y1 -= $y2;
        return ($x1 * $x1 + $y1 * $y1);
    }

    /**
     * Returns the square of the distance from this
     * <code>Point2D</code> to a specified <code>Point2D</code>.
     *
     * @param Point2D $pt the specified point to be measured
     *           against this <code>Point2D</code>
     * @return float the square of the distance between this
     * <code>Point2D</code> to a specified <code>Point2D</code>.
     */
    private function distanceSqToPoint(Point2D $pt)
    {
        $px = $pt->getX() - $this->getX();
        $py = $pt->getY() - $this->getY();
        return ($px * $px + $py * $py);
    }


    public function distance()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->distanceBetweenTwoPoints($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                $this->distanceToXY($args[0], $args[1]);
                break;
            case 1:
                $this->distanceToPoint($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid argument count');
        }

    }


    /**
     * Returns the distance between two points.
     *
     * @param float $x1 the X coordinate of the first specified point
     * @param float $y1 the Y coordinate of the first specified point
     * @param float $x2 the X coordinate of the second specified point
     * @param float $y2 the Y coordinate of the second specified point
     * @return float the distance between the two sets of specified
     * coordinates.
     */
    private function distanceBetweenTwoPoints($x1, $y1, $x2, $y2)
    {
        $x1 -= $x2;
        $y1 -= $y2;
        return sqrt($x1 * $x1 + $y1 * $y1);
    }

    /**
     * Returns the distance from this <code>Point2D</code> to
     * a specified point.
     *
     * @param float $px the X coordinate of the specified point to be measured
     *           against this <code>Point2D</code>
     * @param float $py the Y coordinate of the specified point to be measured
     *           against this <code>Point2D</code>
     * @return float the distance between this <code>Point2D</code>
     * and a specified point.
     */
    private function distanceToXY($px, $py)
    {
        $px -= $this->getX();
        $py -= $this->getY();
        return sqrt($px * $px + $py * $py);
    }

    /**
     * Returns the distance from this <code>Point2D</code> to a
     * specified <code>Point2D</code>.
     *
     * @param Point2D $pt the specified point to be measured
     *           against this <code>Point2D</code>
     * @return float the distance between this <code>Point2D</code> and
     * the specified <code>Point2D</code>.
     */
    private function distanceToPoint(Point2D $pt)
    {
        $px = $pt->getX() - $this->getX();
        $py = $pt->getY() - $this->getY();
        return sqrt($px * $px + $py * $py);
    }

    /**
     * Determines whether or not two points are equal. Two instances of
     * {@code Point2D} are equal if the values of their
     * x and y member fields, representing
     * their position in the coordinate space, are the same.
     * @param Object $obj an object to be compared with this <code>Point2D</code>
     * @return boolean
     * Return true if the object to be compared is
     *         an instance of <code>Point2D</code> and has
     *         the same values; <code>false</code> otherwise.
     * @since 1.2
     */
    public function equals($obj)
    {
        if ($obj instanceof Point2D) {
            return ($this->getX() == $obj->getX()) && ($this->getY() == $obj->getY());
        }
        return $this === $obj;
    }
}