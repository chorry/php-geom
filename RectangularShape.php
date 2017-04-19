<?php
/*
* Copyright (c) 1997, 2011, Oracle and/or its affiliates. All rights reserved.
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
 * <code>RectangularShape</code> is the base class for a number of
 * {@link Shape} objects whose geometry is defined by a rectangular frame.
 * This class does not directly specify any specific geometry by
 * itself, but merely provides manipulation methods inherited by
 * a whole category of Shape objects.
 * The manipulation methods provided by this class can be used to
 * query and modify the rectangular frame, which provides a reference
 * for the subclasses to define their geometry.
 *
 * @author      Jim Graham
 * @since 1.2
 */
abstract class RectangularShape implements Shape
{
    /**
     * Returns the X coordinate of the upper-left corner of
     * the framing rectangle.
     * @return float the X coordinate of the upper-left corner of
     * the framing rectangle.
     * @since 1.2
     */
    abstract public function getX();

    /**
     * Returns the Y coordinate of the upper-left corner of
     * the framing rectangle.
     * @return float the Y coordinate of the upper-left corner of
     * the framing rectangle.
     * @since 1.2
     */
    abstract public function getY();

    /**
     * Returns the width of the framing rectangle
     * @return float the width of the framing rectangle.
     * @since 1.2
     */
    abstract public function getWidth();

    /**
     * Returns the height of the framing rectangle
     * @return float the height of the framing rectangle.
     * @since 1.2
     */
    abstract public function getHeight();

    /**
     * Returns the smallest X coordinate of the framing
     * rectangle of the Shape
     * @return float the smallest X coordinate of the framing
     *          rectangle of the Shape.
     * @since 1.2
     */
    public function getMinX()
    {
        return $this->getX();
    }

    /**
     * Returns the smallest Y coordinate of the framing
     * rectangle of the Shape.
     * @return float the smallest Y coordinate of the framing
     *          rectangle of the Shape.
     * @since 1.2
     */
    public function getMinY()
    {
        return $this->getY();
    }

    /**
     * Returns the largest X coordinate of the framing
     * rectangle of the Shape in <code>double</code>
     * precision.
     * @return float the largest X coordinate of the framing
     *          rectangle of the Shape.
     * @since 1.2
     */
    public function getMaxX()
    {
        return $this->getX() + $this->getWidth();
    }

    /**
     * Returns the largest Y coordinate of the framing
     * rectangle of the Shape in <code>double</code>
     * precision.
     * @return float the largest Y coordinate of the framing
     *          rectangle of the Shape.
     * @since 1.2
     */
    public function getMaxY()
    {
        return $this->getY() + $this->getHeight();
    }

    /**
     * Returns the X coordinate of the center of the framing
     * rectangle of the Shape.
     * @return float the X coordinate of the center of the framing rectangle
     *          of the Shape.
     * @since 1.2
     */
    public function getCenterX()
    {
        return $this->getX() + $this->getWidth() / 2.0;
    }

    /**
     * Returns the Y coordinate of the center of the framing
     * rectangle of the Shape.
     * @return float the Y coordinate of the center of the framing rectangle
     *          of the Shape.
     * @since 1.2
     */
    public function getCenterY()
    {
        return $this->getY() + $this->getHeight() / 2.0;
    }

    /**
     * Returns the framing {@link Rectangle2D}
     * that defines the overall shape of this object.
     * @return Rectangle2D a <code>Rectangle2D</code>, specified in
     * float coordinates.
     * @see #setFrame(double, double, double, double)
     * @see #setFrame(Point2D, Dimension2D)
     * @see #setFrame(Rectangle2D)
     * @since 1.2
     */
    public function getFrame()
    {
        return new Rectangle2D($this->getX(), $this->getY(), $this->getWidth(), $this->getHeight());
    }

    /**
     * Determines whether the <code>RectangularShape</code> is empty.
     * When the <code>RectangularShape</code> is empty, it encloses no
     * area.
     * @return <code>true</code> if the <code>RectangularShape</code> is empty;
     *          <code>false</code> otherwise.
     * @since 1.2
     */
    abstract public function isEmpty();

    /**
     * Sets the location and size of the framing rectangle of this
     * Shape to the specified rectangular values.
     *
     * @param float $x the X coordinate of the upper-left corner of the
     *          specified rectangular shape
     * @param float $y the Y coordinate of the upper-left corner of the
     *          specified rectangular shape
     * @param float $w the width of the specified rectangular shape
     * @param float $h the height of the specified rectangular shape
     * @see #getFrame
     * @since 1.2
     */
    abstract public function setFrame($x, $y, $w, $h);


    /**
     * Sets the location and size of the framing rectangle of this
     * Shape to the specified {@link Point2D} and
     * {@link Dimension2D}, respectively.  The framing rectangle is used
     * by the subclasses of <code>RectangularShape</code> to define
     * their geometry.
     * @param Point2D $loc the specified <code>Point2D</code>
     * @param Dimension2D $size the specified <code>Dimension2D</code>
     * @see #getFrame
     * @since 1.2
     */
    protected function setFrameByPointAndDimension(Point2D $loc, Dimension2D $size)
    {
        $this->setFrame($loc->getX(), $loc->getY(), $size->getWidth(), $size->getHeight());
    }

    /**
     * Sets the framing rectangle of this Shape to
     * be the specified <code>Rectangle2D</code>.  The framing rectangle is
     * used by the subclasses of <code>RectangularShape</code> to define
     * their geometry.
     * @param Rectangle2D $r the specified <code>Rectangle2D</code>
     * @see #getFrame
     * @since 1.2
     */
    protected function setFrameByRectangle2D(Rectangle2D $r)
    {
        $this->setFrame($r->getX(), $r->getY(), $r->getWidth(), $r->getHeight());
    }

    public function setFrameFromDiagonal()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->setFrameFromDiagonalBy4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                $this->setFrameFromDiagonalByPoints($args[0], $args[1]);
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Sets the diagonal of the framing rectangle of this Shape
     * based on the two specified coordinates.  The framing rectangle is
     * used by the subclasses of <code>RectangularShape</code> to define
     * their geometry.
     *
     * @param float $x1 the X coordinate of the start point of the specified diagonal
     * @param float $y1 the Y coordinate of the start point of the specified diagonal
     * @param float $x2 the X coordinate of the end point of the specified diagonal
     * @param float $y2 the Y coordinate of the end point of the specified diagonal
     */
    private function setFrameFromDiagonalBy4($x1, $y1, $x2, $y2)
    {
        if ($x2 < $x1) {
            $t = $x1;
            $x1 = $x2;
            $x2 = $t;
        }
        if ($y2 < $y1) {
            $t = $y1;
            $y1 = $y2;
            $y2 = $t;
        }
        $this->setFrame($x1, $y1, $x2 - $x1, $y2 - $y1);
    }

    /**
     * Sets the diagonal of the framing rectangle of this Shape
     * based on two specified <code>Point2D</code> objects.  The framing
     * rectangle is used by the subclasses of <code>RectangularShape</code>
     * to define their geometry.
     *
     * @param Point2D $p1 the start <code>Point2D</code> of the specified diagonal
     * @param Point2D $p2 the end <code>Point2D</code> of the specified diagonal
     * @since 1.2
     */
    private function setFrameFromDiagonalByPoints(Point2D $p1, Point2D $p2)
    {
        $this->setFrameFromDiagonal($p1->getX(), $p1->getY(), $p2->getX(), $p2->getY());
    }

    public function setFrameFromCenter()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 4:
                $this->setFrameFromCenterBy4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 2:
                $this->setFrameFromCenterByPoints($args[0], $args[1]);
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * Sets the framing rectangle of this Shape
     * based on the specified center point coordinates and corner point
     * coordinates.  The framing rectangle is used by the subclasses of
     * <code>RectangularShape</code> to define their geometry.
     *
     * @param float $centerX the X coordinate of the specified center point
     * @param float $centerY the Y coordinate of the specified center point
     * @param float $cornerX the X coordinate of the specified corner point
     * @param float $cornerY the Y coordinate of the specified corner point
     */
    public function setFrameFromCenterBy4(
        $centerX,
        $centerY,
        $cornerX,
        $cornerY
    ) {
        $halfW = abs($cornerX - $centerX);
        $halfH = abs($cornerY - $centerY);
        $this->setFrame($centerX - $halfW, $centerY - $halfH, $halfW * 2.0, $halfH * 2.0);
    }

    /**
     * Sets the framing rectangle of this Shape based on a
     * specified center <code>Point2D</code> and corner
     * <code>Point2D</code>.  The framing rectangle is used by the subclasses
     * of <code>RectangularShape</code> to define their geometry.
     * @param Point2D $center the specified center <code>Point2D</code>
     * @param Point2D $corner the specified corner <code>Point2D</code>
     * @since 1.2
     */
    public function setFrameFromCenterByPoints(Point2D $center, Point2D $corner)
    {
        $this->setFrameFromCenter($center->getX(), $center->getY(),
            $corner->getX(), $corner->getY());
    }

    public function contains()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                $result = $this->contains($args[0], $args[1]);
                break;
            case 1:
                $result = ($args[0] instanceof Point2D)
                    ? $this->containsPoint($args[0])
                    : $this->containsRectangle($args[0]);
                break;
            default:
                throw new InvalidArgumentException();
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function containsPoint(Point2D $p)
    {
        return $this->contains($p->getX(), $p->getY());
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function containsRectangle(Rectangle2D $r)
    {
        return $this->contains($r->getX(), $r->getY(), $r->getWidth(), $r->getHeight());
    }

    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function intersects()
    {
        $args = func_get_args();
        switch(count($args)) {
            case 4:
                $result = $this->intersects4Params($args[0], $args[1], $args[2], $args[3]);
                break;
            case 1:
                $result = $this->intersectsRectangle2D($args[0]);
                break;
            default:
                throw new InvalidArgumentException();
        }
        return $result;
    }

    /**
     * @param Rectangle2D $r
     * @return bool
     */
    public function intersectsRectangle2D(Rectangle2D $r)
    {
        return $this->intersects4Params($r->getX(), $r->getY(), $r->getWidth(), $r->getHeight());
    }


    /**
     * {@inheritDoc}
     * @since 1.2
     */
    public function getBounds()
    {
        $width = $this->getWidth();
        $height = $this->getHeight();
        if ($width < 0 || $height < 0) {
            return new Rectangle();
        }
        $x = $this->getX();
        $y = $this->getY();
        $x1 = floor($x);
        $y1 = floor($y);
        $x2 = ceil($x + $width);
        $y2 = ceil($y + $height);
        return new Rectangle((int)$x1, (int)$y1,
            (int)($x2 - $x1), (int)($y2 - $y1));
    }

    /**
     * Returns an iterator object that iterates along the
     * Shape object's boundary and provides access to a
     * flattened view of the outline of the Shape
     * object's geometry.
     * <p>
     * Only SEG_MOVETO, SEG_LINETO, and SEG_CLOSE point types will
     * be returned by the iterator.
     * <p>
     * The amount of subdivision of the curved segments is controlled
     * by the <code>flatness</code> parameter, which specifies the
     * maximum distance that any point on the unflattened transformed
     * curve can deviate from the returned flattened path segments.
     * An optional {@link AffineTransform} can
     * be specified so that the coordinates returned in the iteration are
     * transformed accordingly.
     * @param AffineTransform $at an optional <code>AffineTransform</code> to be applied to the
     *          coordinates as they are returned in the iteration,
     *          or <code>null</code> if untransformed coordinates are desired.
     * @param float $flatness the maximum distance that the line segments used to
     *          approximate the curved segments are allowed to deviate
     *          from any point on the original curve
     * @return PathIterator a <code>PathIterator</code> object that provides access to
     *          the Shape object's flattened geometry.
     * @since 1.2
     */
    public function getPathIteratorByATAndFlatness(AffineTransform $at, $flatness)
    {
        return new FlatteningPathIterator($this->getPathIteratorFromShape($at), $flatness);
    }

}