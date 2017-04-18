<?php
/*
* Copyright (c) 1997, 2006, Oracle and/or its affiliates. All rights reserved.
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
 * The <code>Rectangle2D</code> class describes a rectangle
 * defined by a location {@code (x,y)} and dimension
 * {@code (w x h)}.
 * <p>
 * This class is only the abstract superclass for all objects that
 * store a 2D rectangle.
 * The actual storage representation of the coordinates is left to
 * the subclass.
 *
 * @author      Jim Graham
 * @since 1.2
 */
class Rectangle2D extends RectangularShape
{
    /**
     * The bitmask that indicates that a point lies to the left of
     * this <code>Rectangle2D</code>.
     */
    const OUT_LEFT = 1;

    /**
     * The bitmask that indicates that a point lies above
     * this <code>Rectangle2D</code>.
     */
    const OUT_TOP = 2;

    /**
     * The bitmask that indicates that a point lies to the right of
     * this <code>Rectangle2D</code>.
     */
    const OUT_RIGHT = 4;

    /**
     * The bitmask that indicates that a point lies below
     * this <code>Rectangle2D</code>.
     */
    const OUT_BOTTOM = 8;

    /**
     * The X coordinate of this <code>Rectangle2D</code>.
     * @serial
     */
    public $x;

    /**
     * The Y coordinate of this <code>Rectangle2D</code>.
     * @serial
     */
    public $y;

    /**
     * The width of this <code>Rectangle2D</code>.
     * @serial
     */
    public $width;

    /**
     * The height of this <code>Rectangle2D</code>.
     * @serial
     */
    public $height;

    /**
     * Constructs and initializes a <code>Rectangle2D</code>
     * from the specified <code>double</code> coordinates.
     *
     * @param float $x the X coordinate of the upper-left corner
     *          of the newly constructed <code>Rectangle2D</code>
     * @param float $y the Y coordinate of the upper-left corner
     *          of the newly constructed <code>Rectangle2D</code>
     * @param float $w the width of the newly constructed
     *          <code>Rectangle2D</code>
     * @param float $h the height of the newly constructed
     *          <code>Rectangle2D</code>
     */
    public function __construct($x = 0.0, $y = 0.0, $w = 0.0, $h = 0.0)
    {
        $this->setRect($x, $y, $w, $h);
    }

    /**
     * {@inheritDoc}
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * {@inheritDoc}
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return ($this->width <= 0) || ($this->height <= 0);
    }

    public function setRect()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->setRectByParams($args[0], $args[1], $args[2], $args[3]);
                break;
            case 1:
                $this->setRectByObject($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid arguments count');
        }
    }

    /**
     * Sets the location and size of this <code>Rectangle2D</code>
     * to the specified <code>double</code> values.
     *
     * @param float $x the X coordinate of the upper-left corner
     *          of this <code>Rectangle2D</code>
     * @param float $y the Y coordinate of the upper-left corner
     *          of this <code>Rectangle2D</code>
     * @param float $w the width of this <code>Rectangle2D</code>
     * @param float $h the height of this <code>Rectangle2D</code>
     */
    private function setRectByParams($x, $y, $w, $h)
    {
        $this->x = $x;
        $this->y = $y;
        $this->width = $w;
        $this->height = $h;
    }

    /**
     * Sets this <code>Rectangle2D</code> to be the same as the specified
     * <code>Rectangle2D</code>.
     * @param Rectangle2D $r the specified <code>Rectangle2D</code>
     */
    private function setRectByObject(Rectangle2D $r)
    {
        $this->x = $r->getX();
        $this->y = $r->getY();
        $this->width = $r->getWidth();
        $this->height = $r->getHeight();
    }


    public function outcode()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                return $this->outcodeByXY($args[0], $args[1]);
            case 1:
                return $this->outcodeByPoint($args[0]);
            default:
                throw new InvalidArgumentException('Invalid argument count');
        }
    }

    /**
     * Determines where the specified coordinates lie with respect
     * to this <code>Rectangle2D</code>.
     * This method computes a binary OR of the appropriate mask values
     * indicating, for each side of this <code>Rectangle2D</code>,
     * whether or not the specified coordinates are on the same side
     * of the edge as the rest of this <code>Rectangle2D</code>.
     * @param float $x the specified X coordinate
     * @param float $y the specified Y coordinate
     * @return int the logical OR of all appropriate out codes.
     * @see self::OUT_LEFT
     * @see self::OUT_TOP
     * @see self::OUT_RIGHT
     * @see self::OUT_BOTTOM
     */
    public function outcodeByXY($x, $y)
    {
        $out = 0;
        if ($this->width <= 0) {
            $out |= self::OUT_LEFT | self::OUT_RIGHT;
        } else {
            if ($x < $this->x) {
                $out |= self::OUT_LEFT;
            } else {
                if ($x > $this->x + $this->width) {
                    $out |= self::OUT_RIGHT;
                }
            }
        }
        if ($this->height <= 0) {
            $out |= self::OUT_TOP | self::OUT_BOTTOM;
        } else {
            if ($y < $this->y) {
                $out |= self::OUT_TOP;
            } else {
                if ($y > $this->y + $this->height) {
                    $out |= self::OUT_BOTTOM;
                }
            }
        }
        return $out;
    }

    /**
     * Determines where the specified {@link Point2D} lies with
     * respect to this <code>Rectangle2D</code>.
     * This method computes a binary OR of the appropriate mask values
     * indicating, for each side of this <code>Rectangle2D</code>,
     * whether or not the specified <code>Point2D</code> is on the same
     * side of the edge as the rest of this <code>Rectangle2D</code>.
     * @param Point2D $p the specified <code>Point2D</code>
     * @return int the logical OR of all appropriate out codes.
     * @see #OUT_LEFT
     * @see #OUT_TOP
     * @see #OUT_RIGHT
     * @see #OUT_BOTTOM
     */
    public function outcodeByPoint(Point2D $p)
    {
        return $this->outcode($p->getX(), $p->getY());
    }

    /**
     * Returns a new <code>Rectangle2D</code> object representing the
     * intersection of this <code>Rectangle2D</code> with the specified
     * <code>Rectangle2D</code>.
     * @param Rectangle2D $r the <code>Rectangle2D</code> to be intersected with
     * this <code>Rectangle2D</code>
     * @return Rectangle2D the largest <code>Rectangle2D</code> contained in both
     *          the specified <code>Rectangle2D</code> and in this
     *          <code>Rectangle2D</code>.
     */
    public function createIntersection(Rectangle2D $r)
    {
        $dest = new Rectangle2D();
        $this->intersect($this, $r, $dest);
        return $dest;
    }

    /**
     * Returns the <code>String</code> representation of this
     * <code>Rectangle2D</code>.
     * @return string <code>String</code> representing this
     * <code>Rectangle2D</code>.
     */
    public function __toString()
    {
        return sprintf("%s [x=%s, y=%s, w=%s, h=%s]", get_class($this), $this->getX(), $this->getY(),
            $this->getWidth(), $this->getHeight());
    }

    public function intersectsLine()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                return $this->intersectsLineBy4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 1:
                return $this->intersectsLineByLine($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid argument count');
        }
    }

    /**
     * Tests if the specified line segment intersects the interior of this
     * <code>Rectangle2D</code>.
     *
     * @param float $x1 the X coordinate of the start point of the specified
     *           line segment
     * @param float $y1 the Y coordinate of the start point of the specified
     *           line segment
     * @param float $x2 the X coordinate of the end point of the specified
     *           line segment
     * @param float $y2 the Y coordinate of the end point of the specified
     *           line segment
     * @return bool <code>true</code> if the specified line segment intersects
     * the interior of this <code>Rectangle2D</code>; <code>false</code>
     * otherwise.
     */
    private function intersectsLineBy4($x1, $y1, $x2, $y2)
    {
        if (($out2 = $this->outcode($x2, $y2)) == 0) {
            return true;
        }
        while (($out1 = $this->outcode($x1, $y1)) != 0) {
            if (($out1 & $out2) != 0) {
                return false;
            }
            if (($out1 & (self::OUT_LEFT | self::OUT_RIGHT)) != 0) {
                $x = $this->getX();
                if (($out1 & self::OUT_RIGHT) != 0) {
                    $x += $this->getWidth();
                }
                $y1 = $y1 + ($x - $x1) * ($y2 - $y1) / ($x2 - $x1);
                $x1 = $x;
            } else {
                $y = $this->getY();
                if (($out1 & self::OUT_BOTTOM) != 0) {
                    $y += $this->getHeight();
                }
                $x1 = $x1 + ($y - $y1) * ($x2 - $x1) / ($y2 - $y1);
                $y1 = $y;
            }
        }
        return true;
    }

    /**
     * Tests if the specified line segment intersects the interior of this
     * <code>Rectangle2D</code>.
     * @param Line2D $l the specified {@link Line2D} to test for intersection
     * with the interior of this <code>Rectangle2D</code>
     * @return bool <code>true</code> if the specified <code>Line2D</code>
     * intersects the interior of this <code>Rectangle2D</code>;
     * <code>false</code> otherwise.
     */
    private function intersectsLineByLine(Line2D $l)
    {
        return $this->intersectsLine($l->getX1(), $l->getY1(), $l->getX2(), $l->getY2());
    }


    /**
     * Sets the location and size of the outer bounds of this
     * <code>Rectangle2D</code> to the specified rectangular values.
     *
     * @param float $x the X coordinate of the upper-left corner
     *          of this <code>Rectangle2D</code>
     * @param float $y the Y coordinate of the upper-left corner
     *          of this <code>Rectangle2D</code>
     * @param float $w the width of this <code>Rectangle2D</code>
     * @param float $h the height of this <code>Rectangle2D</code>
     */
    public function setFrame($x, $y, $w, $h)
    {
        $this->setRect($x, $y, $w, $h);
    }

    /**
     * {@inheritDoc}
     */
    public function getBounds2D()
    {
        return clone $this;
    }

    /**
     * {@inheritDoc}
     */
    public function intersects($x, $y, $w, $h)
    {
        if ($this->isEmpty() || $w <= 0 || $h <= 0) {
            return false;
        }
        $x0 = $this->getX();
        $y0 = $this->getY();
        return ($x + $w > $x0 &&
            $y + $h > $y0 &&
            $x < $x0 + $this->getWidth() &&
            $y < $y0 + $this->getHeight());
    }


    public function contains()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                return $this->containsBy4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                return $this->containsBy2($args[0], $args[1]);
                break;
            default:
                throw new InvalidArgumentException('Invalid arguments count');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function containsBy4($x, $y, $w, $h)
    {
        if ($this->isEmpty() || $w <= 0 || $h <= 0) {
            return false;
        }
        $x0 = $this->getX();
        $y0 = $this->getY();
        return ($x >= $x0 &&
            $y >= $y0 &&
            ($x + $w) <= $x0 + $this->getWidth() &&
            ($y + $h) <= $y0 + $this->getHeight());
    }

    /**
     * {@inheritDoc}
     */
    private function containsBy2($x, $y)
    {
        $x0 = $this->getX();
        $y0 = $this->getY();
        return ($x >= $x0 &&
            $y >= $y0 &&
            $x < $x0 + $this->getWidth() &&
            $y < $y0 + $this->getHeight());
    }


    /**
     * Intersects the pair of specified source <code>Rectangle2D</code>
     * objects and puts the result into the specified destination
     * <code>Rectangle2D</code> object.  One of the source rectangles
     * can also be the destination to avoid creating a third Rectangle2D
     * object, but in this case the original points of this source
     * rectangle will be overwritten by this method.
     * @param Rectangle2D $src1 the first of a pair of <code>Rectangle2D</code>
     * objects to be intersected with each other
     * @param Rectangle2D $src2 the second of a pair of <code>Rectangle2D</code>
     * objects to be intersected with each other
     * @param Rectangle2D $dest the <code>Rectangle2D</code> that holds the
     * results of the intersection of <code>src1</code> and
     * <code>src2</code>
     */
    public function intersect(
        Rectangle2D $src1,
        Rectangle2D $src2,
        Rectangle2D $dest
    ) {
        $x1 = max($src1->getMinX(), $src2->getMinX());
        $y1 = max($src1->getMinY(), $src2->getMinY());
        $x2 = min($src1->getMaxX(), $src2->getMaxX());
        $y2 = min($src1->getMaxY(), $src2->getMaxY());
        $dest->setFrame($x1, $y1, $x2 - $x1, $y2 - $y1);
    }

    /**
     * Returns a new <code>Rectangle2D</code> object representing the
     * union of this <code>Rectangle2D</code> with the specified
     * <code>Rectangle2D</code>.
     * @param Rectangle2D $r the <code>Rectangle2D</code> to be combined with
     * this <code>Rectangle2D</code>
     * @return Rectangle2D the smallest <code>Rectangle2D</code> containing both
     * the specified <code>Rectangle2D</code> and this
     * <code>Rectangle2D</code>.
     */
    public function createUnion(Rectangle2D $r)
    {
        $dest = new Rectangle2D();
        $this->union($this, $r, $dest);
        return $dest;
    }

    /**
     * Unions the pair of source <code>Rectangle2D</code> objects
     * and puts the result into the specified destination
     * <code>Rectangle2D</code> object.  One of the source rectangles
     * can also be the destination to avoid creating a third Rectangle2D
     * object, but in this case the original points of this source
     * rectangle will be overwritten by this method.
     * @param Rectangle2D $src1 the first of a pair of <code>Rectangle2D</code>
     * objects to be combined with each other
     * @param Rectangle2D $src2 the second of a pair of <code>Rectangle2D</code>
     * objects to be combined with each other
     * @param Rectangle2D $dest the <code>Rectangle2D</code> that holds the
     * results of the union of <code>src1</code> and
     * <code>src2</code>
     */
    public function union(
        Rectangle2D $src1,
        Rectangle2D $src2,
        Rectangle2D $dest
    ) {
        $x1 = min($src1->getMinX(), $src2->getMinX());
        $y1 = min($src1->getMinY(), $src2->getMinY());
        $x2 = max($src1->getMaxX(), $src2->getMaxX());
        $y2 = max($src1->getMaxY(), $src2->getMaxY());
        $dest->setFrameFromDiagonal($x1, $y1, $x2, $y2);
    }

    public function add()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->setRectByParams($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                $this->addXY($args[0], $args[1]);
                break;
            case 1:
                ($args[0] instanceof Point2D)
                    ? $this->addPoint($args[0])
                    : $this->addRectangle($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid arguments count');
        }
    }

    /**
     * Adds a point, specified by the double precision arguments
     * <code>newx</code> and <code>newy</code>, to this
     * <code>Rectangle2D</code>.  The resulting <code>Rectangle2D</code>
     * is the smallest <code>Rectangle2D</code> that
     * contains both the original <code>Rectangle2D</code> and the
     * specified point.
     * <p>
     * After adding a point, a call to <code>contains</code> with the
     * added point as an argument does not necessarily return
     * <code>true</code>. The <code>contains</code> method does not
     * return <code>true</code> for points on the right or bottom
     * edges of a rectangle. Therefore, if the added point falls on
     * the left or bottom edge of the enlarged rectangle,
     * <code>contains</code> returns <code>false</code> for that point.
     * @param float $newx the X coordinate of the new point
     * @param float $newy the Y coordinate of the new point
     */
    private function addXY($newx, $newy)
    {
        $x1 = min($this->getMinX(), $newx);
        $x2 = max($this->getMaxX(), $newx);
        $y1 = min($this->getMinY(), $newy);
        $y2 = max($this->getMaxY(), $newy);
        $this->setRect($x1, $y1, $x2 - $x1, $y2 - $y1);
    }

    /**
     * Adds the <code>Point2D</code> object <code>pt</code> to this
     * <code>Rectangle2D</code>.
     * The resulting <code>Rectangle2D</code> is the smallest
     * <code>Rectangle2D</code> that contains both the original
     * <code>Rectangle2D</code> and the specified <code>Point2D</code>.
     * <p>
     * After adding a point, a call to <code>contains</code> with the
     * added point as an argument does not necessarily return
     * <code>true</code>. The <code>contains</code>
     * method does not return <code>true</code> for points on the right
     * or bottom edges of a rectangle. Therefore, if the added point falls
     * on the left or bottom edge of the enlarged rectangle,
     * <code>contains</code> returns <code>false</code> for that point.
     * @param Point2D $pt the new <code>Point2D</code> to add to this
     * <code>Rectangle2D</code>.
     */
    private function addPoint(Point2D $pt)
    {
        $this->add($pt->getX(), $pt->getY());
    }

    /**
     * Adds a <code>Rectangle2D</code> object to this
     * <code>Rectangle2D</code>.  The resulting <code>Rectangle2D</code>
     * is the union of the two <code>Rectangle2D</code> objects.
     * @param Rectangle2D $r the <code>Rectangle2D</code> to add to this
     * <code>Rectangle2D</code>.
     */
    private function addRectangle(Rectangle2D $r)
    {
        $x1 = min($this->getMinX(), $r->getMinX());
        $x2 = max($this->getMaxX(), $r->getMaxX());
        $y1 = min($this->getMinY(), $r->getMinY());
        $y2 = max($this->getMaxY(), $r->getMaxY());
        $this->setRect($x1, $y1, $x2 - $x1, $y2 - $y1);
    }


    public function getPathIterator()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                return $this->getPathIteratorForFlatRect($args[0], $args[1]);
                break;
            case 1:
                return $this->getPathIteratorForRect($args[0]);
                break;
            default:
                throw new InvalidArgumentException('Invalid arguments count');
        }
    }

    /**
     * Returns an iteration object that defines the boundary of this
     * <code>Rectangle2D</code>.
     * The iterator for this class is multi-threaded safe, which means
     * that this <code>Rectangle2D</code> class guarantees that
     * modifications to the geometry of this <code>Rectangle2D</code>
     * object do not affect any iterations of that geometry that
     * are already in process.
     * @param AffineTransform $at an optional <code>AffineTransform</code> to be applied to
     * the coordinates as they are returned in the iteration, or
     * <code>null</code> if untransformed coordinates are desired
     * @return PathIteratorInterface   the <code>PathIterator</code> object that returns the
     *          geometry of the outline of this
     *          <code>Rectangle2D</code>, one segment at a time.
     */
    public function getPathIteratorForRect(AffineTransform $at)
    {
        return new RectIterator($this, $at);
    }

    /**
     * Returns an iteration object that defines the boundary of the
     * flattened <code>Rectangle2D</code>.  Since rectangles are already
     * flat, the <code>flatness</code> parameter is ignored.
     * The iterator for this class is multi-threaded safe, which means
     * that this <code>Rectangle2D</code> class guarantees that
     * modifications to the geometry of this <code>Rectangle2D</code>
     * object do not affect any iterations of that geometry that
     * are already in process.
     * @param AffineTransform $at an optional <code>AffineTransform</code> to be applied to
     * the coordinates as they are returned in the iteration, or
     * <code>null</code> if untransformed coordinates are desired
     * @param float $flatness the maximum distance that the line segments used to
     * approximate the curved segments are allowed to deviate from any
     * point on the original curve.  Since rectangles are already flat,
     * the <code>flatness</code> parameter is ignored.
     * @return  PathIteratorInterface  the <code>PathIterator</code> object that returns the
     *          geometry of the outline of this
     *          <code>Rectangle2D</code>, one segment at a time.
     */
    public function getPathIteratorForFlatRect(AffineTransform $at, $flatness)
    {
        return new RectIterator($this, $at);
    }

    /**
     * Determines whether or not the specified <code>Object</code> is
     * equal to this <code>Rectangle2D</code>.  The specified
     * <code>Object</code> is equal to this <code>Rectangle2D</code>
     * if it is an instance of <code>Rectangle2D</code> and if its
     * location and size are the same as this <code>Rectangle2D</code>.
     * @param Object $obj <code>Object</code> to be compared with this
     * <code>Rectangle2D</code>.
     * @return     <code>true</code> if <code>obj</code> is an instance
     *                     of <code>Rectangle2D</code> and has
     *                     the same values; <code>false</code> otherwise.
     */
    public function equals($obj)
    {
        if ($obj === $this) {
            return true;
        }
        if ($obj instanceof Rectangle2D) {
            return (($this->getX() == $obj->getX()) &&
                ($this->getY() == $obj->getY()) &&
                ($this->getWidth() == $obj->getWidth()) &&
                ($this->getHeight() == $obj->getHeight()));
        }
        return false;
    }
}