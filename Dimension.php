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
 * The <code>Dimension</code> class encapsulates the width and
 * height of a component (in integer precision) in a single object.
 * The class is
 * associated with certain properties of components. Several methods
 * defined by the <code>Component</code> class and the
 * <code>LayoutManager</code> interface return a
 * <code>Dimension</code> object.
 * <p>
 * Normally the values of <code>width</code>
 * and <code>height</code> are non-negative integers.
 * The constructors that allow you to create a dimension do
 * not prevent you from setting a negative value for these properties.
 * If the value of <code>width</code> or <code>height</code> is
 * negative, the behavior of some methods defined by other objects is
 * undefined.
 *
 * @author      Sami Shaio
 * @author      Arthur van Hoff
 * @see         java.awt.Component
 * @see         java.awt.LayoutManager
 * @since       1.0
 */
class Dimension extends Dimension2D
{

    /**
     * The width dimension; negative values can be used.
     *
     * @serial
     * @see #getSize
     * @see #setSize
     * @since 1.0
     */
    public $width;

    /**
     * The height dimension; negative values can be used.
     *
     * @serial
     * @see #getSize
     * @see #setSize
     * @since 1.0
     */
    public $height;

    public function __construct()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                break;
            case 1:
                $this->createByDimension($args[0]);
                break;
            case 0:
                $this->width = $this->height = 0;
                break;
            default:
                throw new InvalidArgumentException();
        }

    }

    /**
     * Creates an instance of <code>Dimension</code> whose width
     * and height are the same as for the specified dimension.
     *
     * @param  Dimension  $d   the specified dimension for the
     *               <code>width</code> and
     *               <code>height</code> values
     */
    private function createByDimension(Dimension $d)
    {
        $this->createByWH($d->getWidth(), $d->getHeight());
    }

    /**
     * Constructs a <code>Dimension</code> and initializes
     * it to the specified width and specified height.
     *
     * @param int $width the specified width
     * @param int $height the specified height
     */
    private function createByWH($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
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
     * Sets the size of this <code>Dimension</code> object to
     * the specified width and height in double precision.
     * Note that if <code>width</code> or <code>height</code>
     * are larger than <code>Integer.MAX_VALUE</code>, they will
     * be reset to <code>Integer.MAX_VALUE</code>.
     *
     * @param float $width the new width for the <code>Dimension</code> object
     * @param float $height the new height for the <code>Dimension</code> object
     * @since 1.2
     */
    public function setSizeByWH($width, $height)
    {
        $this->width = (int)ceil($width);
        $this->height = (int)ceil($height);
    }

    /**
     * Gets the size of this <code>Dimension</code> object.
     * This method is included for completeness, to parallel the
     * <code>getSize</code> method defined by <code>Component</code>.
     *
     * @return   Dimension the size of this dimension, a new instance of
     *           <code>Dimension</code> with the same width and height
     * @see      java.awt.Dimension#setSize
     * @see      java.awt.Component#getSize
     * @since    1.1
     */
    public function getSize()
    {
        return new Dimension($this->width, $this->height);
    }


    /**
     * Checks whether two dimension objects have equal values.
     * @param Object $obj
     * @return bool
     */
    public function equals($obj)
    {
        if ($obj instanceof Dimension) {
            return ($this->getWidth() === $obj->getWidth()) && ($this->getHeight() === $obj->getHeight());
        }
        return false;
    }


    /**
     * Returns a string representation of the values of this
     * <code>Dimension</code> object's <code>height</code> and
     * <code>width</code> fields. This method is intended to be used only
     * for debugging purposes, and the content and format of the returned
     * string may vary between implementations. The returned string may be
     * empty but may not be <code>null</code>.
     *
     * @return string  a string representation of this <code>Dimension</code>
     *          object
     */
    public function toString()
    {
        return sprintf('%s [width=%s, height=%s]', get_class($this), $this->getWidth(), $this->getHeight());
    }
}