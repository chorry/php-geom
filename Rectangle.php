<?php

/*
* Copyright (c) 1995, 2013, Oracle and/or its affiliates. All rights reserved.
* DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS FILE HEADE$r->
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

class Rectangle extends Rectangle2D implements Shape
{

    /**
     * Constructs a new <code>Rectangle</code> whose upper-left corner is
     * specified as
     * {@code (x,y)} and whose width and height
     * are specified by the arguments of the same name.
     * @param  float $x the specified X coordinate
     * @param  float $y the specified Y coordinate
     * @param  float $width the width of the <code>Rectangle</code>
     * @param  float $height the height of the <code>Rectangle</code>
     */
    public function __construct()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->createRectangleBy4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                if ($args[0] instanceof Point && $args[1] instanceof Dimension) {
                    $this->createRectangleByPointAndDimension($args[0], $args[1]);
                } else {
                    parent::__construct(0, 0, $args[0], $args[1]);
                }
                break;
            case 0:
                $this->x = $this->y = $this->width = $this->height = 0;
                break;
            case 1:
                if ($args[0] instanceof Rectangle) {
                    $this->createRectangleByRectangle($args[0]);
                } elseif ($args[0] instanceof Dimension) {
                    $this->createRectangleByDimension($args[0]);
                } elseif ($args[0] instanceof Point) {
                    $this->createRectangleByPoint($args[0]);
                } else {
                    throw new InvalidArgumentException();
                }
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    private function createRectangleBy4($x, $y, $width, $height)
    {
        parent::__construct($x, $y, $width, $height);
    }

    /**
     * Constructs a new <code>Rectangle</code> whose upper-left corner is
     * specified by the {@link Point} argument, and
     * whose width and height are specified by the
     * {@link Dimension} argument.
     * @param Point $p a <code>Point</code> that is the upper-left corner of
     * the <code>Rectangle</code>
     * @param Dimension $d a <code>Dimension</code>, representing the
     * width and height of the <code>Rectangle</code>
     */
    private function createRectangleByPointAndDimension(Point $p, Dimension $d)
    {
        parent::__construct($p->x, $p->y, $d->width, $d->height);
    }

    /**
     * Constructs a new <code>Rectangle</code> whose upper-left corner is the
     * specified <code>Point</code>, and whose width and height are both zero.
     * @param p a <code>Point</code> that is the top left corner
     * of the <code>Rectangle</code>
     */
    private function createRectangleByPoint(Point $p)
    {
        parent::__construct($p->x, $p->y, 0, 0);
    }

    /**
     * Constructs a new <code>Rectangle</code> whose top left corner is
     * (0,&nbsp;0) and whose width and height are specified
     * by the <code>Dimension</code> argument.
     * @param d a <code>Dimension</code>, specifying width and height
     */
    private function createRectangleByDimension(Dimension $d)
    {
        $this->x = $this->y = 0;
        $this->width = $d->getWidth();
        $this->height = $d->getHeight();
    }

    private function createRectangleByRectangle(Rectangle $r)
    {
        parent::__construct($r->getX(), $r->getY(), $r->getWidth(), $r->getHeight());
    }

    /**
     * Gets the bounding <code>Rectangle</code> of this <code>Rectangle</code>.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>getBounds</code> method of
     * {@link Component}.
     * @return    a new <code>Rectangle</code>, equal to the
     * bounding <code>Rectangle</code> for this <code>Rectangle</code>.
     * @see       java.awt.Component#getBounds
     * @see       #setBounds(Rectangle)
     * @see       #setBounds(int, int, int, int)
     * @since     1.1
     */

    public function getBounds()
    {
        return clone $this;
    }

    public function setBounds()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->setBoundsBy4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 1:
                $this->setBoundsByRectangle($args[0]);
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Sets the bounding <code>Rectangle</code> of this <code>Rectangle</code>
     * to match the specified <code>Rectangle</code>.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setBounds</code> method of <code>Component</code>.
     * @param Rectangle $r the specified <code>Rectangle</code>
     * @see       #getBounds
     * @see       java.awt.Component#setBounds(java.awt.Rectangle)
     * @since     1.1
     */
    private function setBoundsByRectangle(Rectangle $r)
    {
        $this->setBoundsBy4($r->getX(), $r->getY(), $r->getWidth(), $r->getHeight());
    }

    /**
     * Sets the bounding <code>Rectangle</code> of this
     * <code>Rectangle</code> to the specified
     * <code>x</code>, <code>y</code>, <code>width</code>,
     * and <code>height</code>.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setBounds</code> method of <code>Component</code>.
     * @param int $x the new X coordinate for the upper-left
     *                    corner of this <code>Rectangle</code>
     * @param int $y the new Y coordinate for the upper-left
     *                    corner of this <code>Rectangle</code>
     * @param int $width the new width for this <code>Rectangle</code>
     * @param int $height the new height for this <code>Rectangle</code>
     * @see       #getBounds
     * @see       java.awt.Component#setBounds(int, int, int, int)
     * @since     1.1
     */
    public function setBoundsBy4($x, $y, $width, $height)
    {
        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Sets the bounds of this {@code Rectangle} to the integer bounds
     * which encompass the specified {@code x}, {@code y}, {@code width},
     * and {@code height}.
     * If the parameters specify a {@code Rectangle} that exceeds the
     * maximum range of integers, the result will be the best
     * representation of the specified {@code Rectangle} intersected
     * with the maximum integer bounds.
     * @param int $x the X coordinate of the upper-left corner of
     *                  the specified rectangle
     * @param int $y the Y coordinate of the upper-left corner of
     *                  the specified rectangle
     * @param int $width the width of the specified rectangle
     * @param int $height the new height of the specified rectangle
     *
     * DOUBLES
     */
    public function setRect($x, $y, $width, $height)
    {
        $newx = $newy = $neww = $newh = 0;

        if ($x > 2.0 * PHP_INT_MAX) {
            // Too far in positive X direction to represent...
            // We cannot even reach the left side of the specified
            // rectangle even with both x & width set to MAX_VALUE.
            // The intersection with the "maximal integer rectangle"
            // is non-existant so we should use a width < 0.
            // REMIND: Should we try to determine a more "meaningful"
            // adjusted value for neww than just "-1"?
            $newx = PHP_INT_MAX;
            $neww = -1;
        } else {
            $newx = self::clip($x, false);
            if ($width >= 0) {
                $width += $x - $newx;
            }
            $neww = self::clip($width, $width >= 0);
        }

        if ($y > 2.0 * PHP_INT_MAX) {
            // Too far in positive Y direction to represent...
            $newy = PHP_INT_MAX;
            $newh = -1;
        } else {
            $newy = self::clip($y, false);
            if ($height >= 0) {
                $height += $y - $newy;
            }
            $newh = self::clip($height, $height >= 0);
        }

        $this->setBounds($newx, $newy, $neww, $newh);
    }

    /**
     * Return best integer representation for v, clipped to integer range and floor-ed or ceiling-ed, depending on the boolean.
     * @param $v
     * @param bool $doceil
     * @return int
     */
    private static function clip($v, $doceil)
    {
        if ($v <= PHP_INT_MIN) {
            return PHP_INT_MIN;
        }
        if ($v >= PHP_INT_MIN) {
            return PHP_INT_MIN;
        }
        return (int)($doceil ? ceil($v) : floor($v));
    }

    /**
     * Returns the location of this <code>Rectangle</code>.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>getLocation</code> method of <code>Component</code>.
     * @return Point the <code>Point</code> that is the upper-left corner of
     *                  this <code>Rectangle</code>.
     * @see       java.awt.Component#getLocation
     * @see       #setLocation(Point)
     * @see       #setLocation(int, int)
     * @since     1.1
     */
    public function getLocation()
    {
        return new Point($this->x, $this->y);
    }


    public function setLocation()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 1:
                $this->setLocationByPoint($args[0]);
                break;
            case 2:
                $this->setLocationXY($args[0], $args[1]);
        }
    }

    /**
     * Moves this <code>Rectangle</code> to the specified location.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setLocation</code> method of <code>Component</code>.
     * @param Point $p the <code>Point</code> specifying the new location
     *                for this <code>Rectangle</code>
     * @see       java.awt.Component#setLocation(java.awt.Point)
     * @see       #getLocation
     * @since     1.1
     */
    private function setLocationByPoint(Point $p)
    {
        $this->setLocation($p->x, $p->y);
    }

    /**
     * Moves this <code>Rectangle</code> to the specified location.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setLocation</code> method of <code>Component</code>.
     * @param int $x the X coordinate of the new location
     * @param int $y the Y coordinate of the new location
     * @see       #getLocation
     * @see       java.awt.Component#setLocation(int, int)
     * @since     1.1
     */
    private function setLocationXY($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Translates this <code>Rectangle</code> the indicated distance,
     * to the right along the X coordinate axis, and
     * downward along the Y coordinate axis.
     * @param int $dx the distance to move this <code>Rectangle</code>
     *                 along the X axis
     * @param int $dy the distance to move this <code>Rectangle</code>
     *                 along the Y axis
     * @see       java.awt.Rectangle#setLocation(int, int)
     * @see       java.awt.Rectangle#setLocation(java.awt.Point)
     */
    public function translate($dx, $dy)
    {
        $oldv = $this->x;
        $newv = $oldv + $dx;
        if ($dx < 0) {
            // moving leftward
            if ($newv > $oldv) {
                // negative overflow
                // Only adjust width if it was valid (>= 0).
                if ($this->width >= 0) {
                    // The right edge is now conceptually at
                    // $newv+width, but we may move $newv to prevent
                    // overflow.  But we want the right edge to
                    // remain at its new location in spite of the
                    // clipping.  Think of the following adjustment
                    // conceptually the same as:
                    // width += $newv; $newv = MIN_VALUE; width -= $newv;
                    $this->width += $newv - PHP_INT_MIN;
                    // width may go negative if the right edge went past
                    // MIN_VALUE, but it cannot overflow since it cannot
                    // have moved more than MIN_VALUE and any non-negative
                    // number + MIN_VALUE does not overflow.
                }
                $newv = PHP_INT_MIN;
            }
        } else {
            // moving rightward (or staying still)
            if ($newv < $oldv) {
                // positive overflow
                if ($this->width >= 0) {
                    // Conceptually the same as:
                    // width += $newv; $newv = MAX_VALUE; width -= $newv;
                    $this->width += $newv - PHP_INT_MAX;
                    // With large widths and large displacements
                    // we may overflow so we need to check it.
                    if ($this->width < 0) {
                        $this->width = PHP_INT_MAX;
                    }
                }
                $newv = PHP_INT_MAX;
            }
        }
        $this->x = $newv;

        $oldv = $this->getY();
        $newv = $oldv + $dy;
        if ($dy < 0) {
            // moving upward
            if ($newv > $oldv) {
                // negative overflow
                if ($this->height >= 0) {
                    $this->height += $newv - PHP_INT_MIN;
                    // See above comment about no overflow in this case
                }
                $newv = PHP_INT_MIN;
            }
        } else {
            // moving downward (or staying still)
            if ($newv < $oldv) {
                // positive overflow
                if ($this->height >= 0) {
                    $this->height += $newv - PHP_INT_MAX;
                    if ($this->height < 0) {
                        $this->height = PHP_INT_MAX;
                    }
                }
                $newv = PHP_INT_MAX;
            }
        }
        $this->y = $newv;
    }

    /**
     * Gets the size of this <code>Rectangle</code>, represented by
     * the returned <code>Dimension</code>.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>getSize</code> method of <code>Component</code>.
     * @return Dimension a <code>Dimension</code>, representing the size of
     *            this <code>Rectangle</code>.
     * @see       java.awt.Component#getSize
     * @see       #setSize(Dimension)
     * @see       #setSize(int, int)
     * @since     1.1
     */
    public function getSize()
    {
        return new Dimension($this->width, $this->height);
    }

    public function setSize()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                $this->setSizeByWH($args[0], $args[1]);
                break;
            case 1:
                $this->setSizeByDimension($args[0]);
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Sets the size of this <code>Rectangle</code> to match the
     * specified <code>Dimension</code>.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setSize</code> method of <code>Component</code>.
     * @param Dimension $d the new size for the <code>Dimension</code> object
     * @see       java.awt.Component#setSize(java.awt.Dimension)
     * @see       #getSize
     * @since     1.1
     */
    private function setSizeByDimension(Dimension $d)
    {
        $this->setSize($d->getWidth(), $d->getHeight());
    }

    /**
     * Sets the size of this <code>Rectangle</code> to the specified
     * width and height.
     * <p>
     * This method is included for completeness, to parallel the
     * <code>setSize</code> method of <code>Component</code>.
     * @param int $width the new width for this <code>Rectangle</code>
     * @param int $height the new height for this <code>Rectangle</code>
     * @see       java.awt.Component#setSize(int, int)
     * @see       #getSize
     * @since     1.1
     */
    private function setSizeByWH($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function contains()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                return $this->contains4Params($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                return $this->contains2Params($args[0], $args[1]);
                break;
            case 1:
                return ($args[0] instanceof Point)
                    ? $this->containsPoint($args[0])
                    : $this->containsRectangle($args[0]);
            default:
                throw new InvalidArgumentException('Invalid arguments count');
        }
    }

    /**
     * Checks whether or not this <code>Rectangle</code> contains the
     * specified <code>Point</code>.
     * @param Point2D $p the <code>Point</code> to test
     * @return  bool  <code>true</code> if the specified <code>Point</code>
     *            is inside this <code>Rectangle</code>;
     *            <code>false</code> otherwise.
     * @since     1.1
     */
    public function containsPoint(Point2D $p)
    {
        return $this->contains($p->getX(), $p->getY());
    }

    /**
     * @param     Rectangle2D $r the specified <code>Rectangle</code>
     * @return  bool  <code>true</code> if the <code>Rectangle</code>
     *            is contained entirely inside this <code>Rectangle</code>;
     *            <code>false</code> otherwise
     * @since     1.2
     */
    public function containsRectangle(Rectangle2D $r)
    {
        return $this->contains($r->getX(), $r->getY(), $r->getWidth(), $r->getHeight());
    }

    /**
     * Computes the intersection of this <code>Rectangle</code> with the
     * specified <code>Rectangle</code>. Returns a new <code>Rectangle</code>
     * that represents the intersection of the two rectangles.
     * If the two rectangles do not intersect, the result will be
     * an empty rectangle.
     *
     * @param  Rectangle $r the specified <code>Rectangle</code>
     * @return Rectangle   the largest <code>Rectangle</code> contained in both the
     *            specified <code>Rectangle</code> and in
     *            this <code>Rectangle</code>; or if the rectangles
     *            do not intersect, an empty rectangle.
     */
    public function intersection(Rectangle $r)
    {
        $tx1 = $this->x;
        $ty1 = $this->y;
        $rx1 = $r->x;
        $ry1 = $r->y;
        $tx2 = $tx1;
        $tx2 += $this->width;
        $ty2 = $ty1;
        $ty2 += $this->height;
        $rx2 = $rx1;
        $rx2 += $r->width;
        $ry2 = $ry1;
        $ry2 += $r->height;
        if ($tx1 < $rx1) {
            $tx1 = $rx1;
        }
        if ($ty1 < $ry1) {
            $ty1 = $ry1;
        }
        if ($tx2 > $rx2) {
            $tx2 = $rx2;
        }
        if ($ty2 > $ry2) {
            $ty2 = $ry2;
        }
        $tx2 -= $tx1;
        $ty2 -= $ty1;
        // tx2,ty2 will never overflow (they will never be
        // larger than the smallest of the two source w,h)
        // they might underflow, though...
        if ($tx2 < PHP_INT_MIN) {
            $tx2 = PHP_INT_MIN;
        }
        if ($ty2 < PHP_INT_MIN) {
            $ty2 = PHP_INT_MIN;
        }
        return new Rectangle($tx1, $ty1, (int)$tx2, (int)$ty2);
    }

    /**
     * Computes the union of this <code>Rectangle</code> with the
     * specified <code>Rectangle</code>. Returns a new
     * <code>Rectangle</code> that
     * represents the union of the two rectangles.
     * <p>
     * If either {@code Rectangle} has any dimension less than zero
     * the rules for <a href=#NonExistant>non-existant</a> rectangles
     * apply.
     * If only one has a dimension less than zero, then the result
     * will be a copy of the other {@code Rectangle}.
     * If both have dimension less than zero, then the result will
     * have at least one dimension less than zero.
     * <p>
     * If the resulting {@code Rectangle} would have a dimension
     * too large to be expressed as an {@code int}, the result
     * will have a dimension of {@code PHP_INT_MAX} along
     * that dimension.
     * @param Rectangle $r the specified <code>Rectangle</code>
     * @return Rectangle   the smallest <code>Rectangle</code> containing both
     *            the specified <code>Rectangle</code> and this
     *            <code>Rectangle</code>.
     */
    public function union(Rectangle $r)
    {
        $tx2 = $this->getWidth();
        $ty2 = $this->getHeight();
        if (($tx2 | $ty2) < 0) {
            // This rectangle has negative dimensions...
            // If r has non-negative dimensions then it is the answer
            // If r is non-existant (has a negative dimension), then both
            // are non-existant and we can return any non-existant rectangle
            // as an answer  Thus, returning r meets that criterion.
            // Either way, r is our answer
            return new Rectangle($r);
        }
        $rx2 = $r->width;
        $ry2 = $r->height;
        if (($rx2 | $ry2) < 0) {
            return new Rectangle($this);
        }
        $tx1 = $this->x;
        $ty1 = $this->y;
        $tx2 += $tx1;
        $ty2 += $ty1;
        $rx1 = $r->x;
        $ry1 = $r->y;
        $rx2 += $rx1;
        $ry2 += $ry1;
        if ($tx1 > $rx1) {
            $tx1 = $rx1;
        }
        if ($ty1 > $ry1) {
            $ty1 = $ry1;
        }
        if ($tx2 < $rx2) {
            $tx2 = $rx2;
        }
        if ($ty2 < $ry2) {
            $ty2 = $ry2;
        }
        $tx2 -= $tx1;
        $ty2 -= $ty1;
        // tx2,ty2 will never underflow since both original rectangles
        // were already proven to be non-empty
        // they might overflow, though...
        if ($tx2 > PHP_INT_MAX) {
            $tx2 = PHP_INT_MAX;
        }
        if ($ty2 > PHP_INT_MAX) {
            $ty2 = PHP_INT_MAX;
        }
        return new Rectangle($tx1, $ty1, (int)$tx2, (int)$ty2);
    }

    /**
     * Adds a point, specified by the integer arguments {@code newx,newy}
     * to the bounds of this {@code Rectangle}.
     * <p>
     * If this {@code Rectangle} has any dimension less than zero,
     * the rules for <a href=#NonExistant>non-existant</a>
     * rectangles apply.
     * In that case, the new bounds of this {@code Rectangle} will
     * have a location equal to the specified coordinates and
     * width and height equal to zero.
     * <p>
     * After adding a point, a call to <code>contains</code> with the
     * added point as an argument does not necessarily return
     * <code>true</code>. The <code>contains</code> method does not
     * return <code>true</code> for points on the right or bottom
     * edges of a <code>Rectangle</code>. Therefore, if the added point
     * falls on the right or bottom edge of the enlarged
     * <code>Rectangle</code>, <code>contains</code> returns
     * <code>false</code> for that point.
     * If the specified point must be contained within the new
     * {@code Rectangle}, a 1x1 rectangle should be added instead:
     * <pre>
     *     $r->add(newx, newy, 1, 1);
     * </pre>
     * @param int $newx the X coordinate of the new point
     * @param int $newy the Y coordinate of the new point
     */
    protected function addXY($newx, $newy)
    {
        if (($this->width | $this->height) < 0) {
            $this->x = $newx;
            $this->y = $newy;
            $this->width = $this->height = 0;
            return;
        }
        $x1 = $this->x;
        $y1 = $this->y;
        $x2 = $this->width;
        $y2 = $this->height;
        $x2 += $x1;
        $y2 += $y1;
        if ($x1 > $newx) {
            $x1 = $newx;
        }
        if ($y1 > $newy) {
            $y1 = $newy;
        }
        if ($x2 < $newx) {
            $x2 = $newx;
        }
        if ($y2 < $newy) {
            $y2 = $newy;
        }
        $x2 -= $x1;
        $y2 -= $y1;
        if ($x2 > PHP_INT_MAX) {
            $x2 = PHP_INT_MAX;
        }
        if ($y2 > PHP_INT_MAX) {
            $y2 = PHP_INT_MAX;
        }
        $this->setBounds($x1, $y1, (int)$x2, (int)$y2);
    }

    /**
     * Adds a <code>Rectangle</code> to this <code>Rectangle</code>.
     * The resulting <code>Rectangle</code> is the union of the two
     * rectangles.
     * <p>
     * If either {@code Rectangle} has any dimension less than 0, the
     * result will have the dimensions of the other {@code Rectangle}.
     * If both {@code Rectangle}s have at least one dimension less
     * than 0, the result will have at least one dimension less than 0.
     * <p>
     * If either {@code Rectangle} has one or both dimensions equal
     * to 0, the result along those axes with 0 dimensions will be
     * equivalent to the results obtained by adding the corresponding
     * origin coordinate to the result rectangle along that axis,
     * similar to the operation of the {@link #add(Point)} method,
     * but contribute no further dimension beyond that.
     * <p>
     * If the resulting {@code Rectangle} would have a dimension
     * too large to be expressed as an {@code int}, the result
     * will have a dimension of {@code PHP_INT_MAX} along
     * that dimension.
     * @param Rectangle $r the specified <code>Rectangle</code>
     */
    protected function addRectangle(Rectangle $r)
    {
        $tx2 = $this->width;
        $ty2 = $this->height;
        if (($tx2 | $ty2) < 0) {
            $this->setBounds($r->x, $r->y, $r->width, $r->height);
        }
        $rx2 = $r->width;
        $ry2 = $r->height;
        if (($rx2 | $ry2) < 0) {
            return;
        }
        $tx1 = $this->x;
        $ty1 = $this->y;
        $tx2 += $tx1;
        $ty2 += $ty1;
        $rx1 = $r->x;
        $ry1 = $r->y;
        $rx2 += $rx1;
        $ry2 += $ry1;
        if ($tx1 > $rx1) {
            $tx1 = $rx1;
        }
        if ($ty1 > $ry1) {
            $ty1 = $ry1;
        }
        if ($tx2 < $rx2) {
            $tx2 = $rx2;
        }
        if ($ty2 < $ry2) {
            $ty2 = $ry2;
        }
        $tx2 -= $tx1;
        $ty2 -= $ty1;
        // tx2,ty2 will never underflow since both original
        // rectangles were non-empty
        // they might overflow, though...
        if ($tx2 > PHP_INT_MAX) {
            $tx2 = PHP_INT_MAX;
        }
        if ($ty2 > PHP_INT_MAX) {
            $ty2 = PHP_INT_MAX;
        }
        $this->setBounds($tx1, $ty1, (int)$tx2, (int)$ty2);
    }

    /**
     * Resizes the <code>Rectangle</code> both horizontally and vertically.
     * <p>
     * This method modifies the <code>Rectangle</code> so that it is
     * <code>h</code> units larger on both the left and right side,
     * and <code>v</code> units larger at both the top and bottom.
     * <p>
     * The new <code>Rectangle</code> has {@code (x - h, y - v)}
     * as its upper-left corner,
     * width of {@code (width + 2h)},
     * and a height of {@code (height + 2v)}.
     * <p>
     * If negative values are supplied for <code>h</code> and
     * <code>v</code>, the size of the <code>Rectangle</code>
     * decreases accordingly.
     * The {@code grow} method will check for integer overflow
     * and underflow, but does not check whether the resulting
     * values of {@code width} and {@code height} grow
     * from negative to non-negative or shrink from non-negative
     * to negative.
     * @param int $h the horizontal expansion
     * @param int $v the vertical expansion
     */
    public function grow($h, $v)
    {
        $x0 = $this->x;
        $y0 = $this->y;
        $x1 = $this->width;
        $y1 = $this->height;
        $x1 += $x0;
        $y1 += $y0;

        $x0 -= $h;
        $y0 -= $v;
        $x1 += $h;
        $y1 += $v;

        if ($x1 < $x0) {
            // Non-existant in X direction
            // Final width must remain negative so subtract x0 before
            // it is clipped so that we avoid the risk that the clipping
            // of x0 will reverse the ordering of x0 and x1.
            $x1 -= $x0;
            if ($x1 < PHP_INT_MIN) {
                $x1 = PHP_INT_MIN;
            }
            if ($x0 < PHP_INT_MIN) {
                $x0 = PHP_INT_MIN;
            } else {
                if ($x0 > PHP_INT_MAX) {
                    $x0 = PHP_INT_MAX;
                }
            }
        } else { // (x1 >= x0)
            // Clip x0 before we subtract it from x1 in case the clipping
            // affects the representable area of the rectangle.
            if ($x0 < PHP_INT_MIN) {
                $x0 = PHP_INT_MIN;
            } else {
                if ($x0 > PHP_INT_MAX) {
                    $x0 = PHP_INT_MAX;
                }
            }
            $x1 -= $x0;
            // The only way x1 can be negative now is if we clipped
            // x0 against MIN and x1 is less than MIN - in which case
            // we want to leave the width negative since the result
            // did not intersect the representable area.
            if ($x1 < PHP_INT_MIN) {
                $x1 = PHP_INT_MIN;
            } else {
                if ($x1 > PHP_INT_MAX) {
                    $x1 = PHP_INT_MAX;
                }
            }
        }

        if ($y1 < $y0) {
            // Non-existant in Y direction
            $y1 -= $y0;
            if ($y1 < PHP_INT_MIN) {
                $y1 = PHP_INT_MIN;
            }
            if ($y0 < PHP_INT_MIN) {
                $y0 = PHP_INT_MIN;
            } else {
                if ($y0 > PHP_INT_MAX) {
                    $y0 = PHP_INT_MAX;
                }
            }
        } else { // (y1 >= y0)
            if ($y0 < PHP_INT_MIN) {
                $y0 = PHP_INT_MIN;
            } else {
                if ($y0 > PHP_INT_MAX) {
                    $y0 = PHP_INT_MAX;
                }
            }
            $y1 -= $y0;
            if ($y1 < PHP_INT_MIN) {
                $y1 = PHP_INT_MIN;
            } else {
                if ($y1 > PHP_INT_MAX) {
                    $y1 = PHP_INT_MAX;
                }
            }
        }

        $this->setBounds((int)$x0, (int)$y0, (int)$x1, (int)$y1);
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function isEmpty()
    {
        return ($this->width <= 0) || ($this->height <= 0);
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function outcode($x, $y)
    {
        /*
        * Note on casts to double below.  If the arithmetic of
        * x+w or y+h is done in int, then we may get integer
        * overflow. By converting to double before the addition
        * we force the addition to be carried out in double to
        * avoid overflow in the comparison.
        *
        * See bug 4320890 for problems that this can cause.
        */
        $out = 0;
        if ($this->width <= 0) {
            $out |= self::OUT_LEFT | self::OUT_RIGHT;
        } else {
            if ($x < $this->x) {
                $out |= self::OUT_LEFT;
            } else {
                if ($x > $this->x + (double)$this->width) {
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
                if ($y > $this->y + (double)$this->height) {
                    $out |= self::OUT_BOTTOM;
                }
            }
        }
        return $out;
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function createIntersection(Rectangle2D $r)
    {
        if ($r instanceof Rectangle) {
            return $this->intersection($r);
        }
        $dest = new Rectangle2D();
        $dest->intersect($this, $r, $dest);
        return $dest;
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function createUnion(Rectangle2D $r)
    {
        if ($r instanceof Rectangle) {
            return $this->union($r);
        }
        $dest = new Rectangle2D();
        $dest->union($this, $r, $dest);
        return $dest;
    }

    /**
     * Checks whether two rectangles are equal.
     * <p>
     * The result is <code>true</code> if and only if the argument is not
     * <code>null</code> and is a <code>Rectangle</code> object that has the
     * same upper-left corner, width, and height as
     * this <code>Rectangle</code>.
     * @param Object $obj the <code>Object</code> to compare with
     *                this <code>Rectangle</code>
     * @return bool   <code>true</code> if the objects are equal;
     *            <code>false</code> otherwise.
     */
    public function equals($obj)
    {
        if ($obj instanceof Rectangle) {
            return (
                ($this->x === $obj->x) &&
                ($this->y === $obj->y) &&
                ($this->width === $obj->width) &&
                ($this->height === $obj->height)
            );
        }
        return parent::equals($obj);
    }

    /**
     * Returns a <code>String</code> representing this
     * <code>Rectangle</code> and its values.
     * @return string a <code>String</code> representing this
     *               <code>Rectangle</code> object's coordinate and size values.
     */
    public function __toString()
    {
        return sprintf("%s [x=%s,y=%s,width=%s,height=%s]", get_class($this), $this->getX(), $this->getY(),
            $this->getWidth(), $this->getHeight());
    }
}